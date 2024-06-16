<?php

namespace App\Services;

use App\Google;
use App\Models\Calendar;
use App\Models\Event;
use App\Models\HR;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Google\Service\Calendar\AclRule;
use Google\Service\Calendar\AclRuleScope;
use Google\Service\Exception;
use Google\Service\HangoutsChat;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_ConferenceSolutionKey;
use Google_Service_Calendar_CreateConferenceRequest;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Http;


class CalendarService
{

    private $client;

    public function __construct(protected Google $google)
    {
        $this->client = $this->google->client();
    }

    public function loginWithGoogle($user, $code): array
    {
        $client = $this->google->client();
        $token = $client->fetchAccessTokenWithAuthCode($code);
        $client->setAccessToken($token);

        $hr = $user->hrable;
        if ($hr->token == null) {
            $hr->token = json_encode($token);
            $hr->save();

            $calendar = new Calendar();
            $calendar->hr_id = $hr->id;
            $calendar->title = 'Venari. Календарь пользователя ' . $hr->user->first_name . " " . $hr->user->last_name;

            $title = $calendar->title;

            // todo Поменять в проде на Москву
            $timezone = env('APP_TIMEZONE');

            $cal = new Google_Service_Calendar($client);

            $google_calendar = new Google_Service_Calendar_Calendar($client);
            $google_calendar->setSummary($title);
            $google_calendar->setTimeZone($timezone);

            $created_calendar = $cal->calendars->insert($google_calendar);

            $calendar->g_calendar_id = $created_calendar->getId();
            $calendar->sync_token = '';
            $calendar->save();

        } else {
            $calendar = Calendar::where('hr_id', $hr->id)->first();
        }

        session([
            'g_cal_token' => $token
        ]);

        return ['message' => 'successfully authenticated with Google'];
    }

    public function createRedirectUrl(): array
    {
        $this->client = $this->google->client();
        $auth_url = $this->client->createAuthUrl();

        return ['message' => $auth_url];
    }

    private function createGCalendar(Calendar $calendar): array
    {
        $this->client->setAccessToken(session('g_cal_token'));

        $title = $calendar->title;

        // todo Поменять в проде на Москву
        $timezone = env('APP_TIMEZONE');

        $cal = new Google_Service_Calendar($this->client);

        $google_calendar = new Google_Service_Calendar_Calendar($this->client);
        $google_calendar->setSummary($title);
        $google_calendar->setTimeZone($timezone);

        $created_calendar = $cal->calendars->insert($google_calendar);

        $calendar->g_calendar_id = $created_calendar->getId();

        $calendar->save();

        return $calendar->toArray();
    }

    public function createEvents(User   $user,
                                 string $startTime,
                                 string $endTime,
                                 int    $slotDuration,
                                 int    $breakDuration,
                                 array  $days,
                                 bool   $isCreateMeets
    ): array
    {
        foreach ($days as $day) {
            $startDateTime = DateTime::createFromFormat('H:i d.m.Y', $startTime . ' ' . $day);
            $endDateTime = DateTime::createFromFormat('H:i d.m.Y', $endTime . ' ' . $day);

            $i = $startDateTime;

            while ($i < $endDateTime) {
                $endDateTimeApproximate = clone $i;
                $endDateTimeApproximate = $endDateTimeApproximate->modify('+' . $slotDuration . ' minutes');

                if ($endDateTimeApproximate <= $endDateTime) {

                    if (Event::where(function (Builder $query) use ($i, $endDateTimeApproximate) {
                            $query->where('datetime_start', '<=', $endDateTimeApproximate)
                                ->where('datetime_start', '>=', $i);
                        })->orWhere(function (Builder $query) use ($i, $endDateTimeApproximate) {
                            $query->where('datetime_end', '<=', $endDateTimeApproximate)
                                ->where('datetime_end', '>=', $i);
                        })->count() != null or
                        Event::where('datetime_start', '<=', $i)->where('datetime_end', '>=', $endDateTimeApproximate)
                            ->count() != null) {
                        $i = clone $endDateTimeApproximate;
                        $i->modify('+' . $breakDuration . ' minutes');

                        continue;
                    }

                    $event = new Event([
                        'datetime_start' => $i,
                        'datetime_end' => $endDateTimeApproximate,
                        'calendar_id' => $user->hrable->calendar->id,
                        'title' => 'Свободный слот для интервью'
                    ]);

                    $event->save();

                    $this->createGEvent($event, $isCreateMeets);

                }

                $i = clone $endDateTimeApproximate;
                $i->modify('+' . $breakDuration . ' minutes');
            }
        }

        return ['message' => 'Events created successfully'];

    }

    public function createGEvent(Event $event, bool $isMeet): array
    {
        $baseTimezone = env('APP_TIMEZONE');


        $this->client->setAccessToken(auth()->user()->hrable->token);

        $startDateTime = Carbon::createFromFormat('Y/m/d H:i', $event->datetime_start->format('Y/m/d H:i'),
            $baseTimezone);
        $endDateTime = Carbon::createFromFormat('Y/m/d H:i', $event->datetime_end->format('Y/m/d H:i'),
            $baseTimezone);

        $cal = new Google_Service_Calendar($this->client);
        $gEvent = new Google_Service_Calendar_Event();
        $gEvent->setSummary($event->title);

        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($startDateTime->toAtomString());
        $gEvent->setStart($start);

        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($endDateTime->toAtomString());
        $gEvent->setEnd($end);

        if ($isMeet) {
            $conferenceData = new Google_Service_Calendar_ConferenceData();
            $request = new Google_Service_Calendar_CreateConferenceRequest();
            $request->setRequestId(uniqid());
            $conferenceSolutionKey = new Google_Service_Calendar_ConferenceSolutionKey();

            $conferenceSolutionKey->setType('hangoutsMeet');
            $request->setConferenceSolutionKey($conferenceSolutionKey);
            $conferenceData->setCreateRequest($request);

            $gEvent->setConferenceData($conferenceData);
        }

        $created_event = $cal->events->insert($event->calendar->g_calendar_id, $gEvent,
            ['conferenceDataVersion' => 1]);

        $event->g_event_id = $created_event->id;
        $event->meet_link = $created_event->getHangoutLink();
        $event->save();

        return $event->toArray();
    }

    public function syncCalendarFromG(int $calendarId)
    {
        $this->client->setAccessToken(session('g_cal_token'));

        $baseTimezone = env('APP_TIMEZONE');

        $calendar = Calendar::find($calendarId);
        $syncToken = $calendar->sync_token;
        $gCalendarID = $calendar->g_calendar_id;

        $gCal = new Google_Service_Calendar($this->client);

        $gCalendar = $gCal->calendars->get($gCalendarID);
        $calendarTimezone = $gCalendar->getTimeZone();

        $events = Event::where('calendar_id', $calendarId)
            ->pluck('g_event_id')
            ->toArray();

        $params = [
            'showDeleted' => true,
            'timeMin' => Carbon::now()
                ->setTimezone($calendarTimezone)
                ->toAtomString()
        ];

        if (!empty($syncToken)) {
            $params = [
                'syncToken' => $syncToken
            ];
        }

        $googleCalendarEvents = $gCal->events->listEvents($gCalendarID, $params);

        while (true) {
            foreach ($googleCalendarEvents->getItems() as $gEvent) {
                $gEventID = $gEvent->id;
                $gEventTitle = $gEvent->getSummary();
                $gStatus = $gEvent->status;

                if ($gStatus != 'cancelled') {
                    $gDateTimeStart = Carbon::parse($gEvent->getStart()->getDateTime())
                        ->tz($calendarTimezone)
                        ->setTimezone($baseTimezone)
                        ->format('Y-m-d H:i:s');

                    $gDateTimeEnd = Carbon::parse($gEvent->getEnd()->getDateTime())
                        ->tz($calendarTimezone)
                        ->setTimezone($baseTimezone)
                        ->format('Y-m-d H:i:s');

                    if (in_array($gEventID, $events)) {
                        $event = Event::where('g_event_id', $gEventID)->first();
                        $event->title = $gEventTitle;
                        $event->meet_link = $gEvent->getHangoutLink();
                        $event->datetime_start = $gDateTimeStart;
                        $event->datetime_end = $gDateTimeEnd;
                        $event->save();
                    } else {
                        $event = new Event;
                        $event->title = $gEventTitle;
                        $event->calendar_id = $calendarId;
                        $event->g_event_id = $gEventID;
                        $event->datetime_start = $gDateTimeStart;
                        $event->datetime_end = $gDateTimeEnd;
                        $event->save();
                    }

                } else {
                    if (in_array($gEventID, $events)) {
                        Event::where('g_event_id', $gEventID)->delete();
                    }
                }

            }

            $pageToken = $googleCalendarEvents->getNextPageToken();
            if ($pageToken) {
                $params['pageToken'] = $pageToken;
                $googleCalendarEvents = $gCal->events->listEvents($gCalendarID, $params);
            } else {
                $nextSyncToken = str_replace('=ok', '', $googleCalendarEvents->getNextSyncToken());

                $calendar = Calendar::find($calendarId);
                $calendar->sync_token = $nextSyncToken;
                $calendar->last_synced_at = new DateTime();
                $calendar->save();

                break;
            }
        }

        return ['message' => 'Calendars successfully synced'];
    }

    public function syncGFromCalendar(int $calendarId)
    {
        $this->client->setAccessToken(session('g_cal_token'));

        $baseTimezone = env('APP_TIMEZONE');
        $calendar = Calendar::find($calendarId);
        $gCalendarID = $calendar->g_calendar_id;

        $gCal = new Google_Service_Calendar($this->client);

        $events = Event::where('updated_at', '>', $calendar->last_synced_at)->get();

        foreach ($events as $event) {
            $this->updateGEvent($gCal, $gCalendarID, $event, $baseTimezone);
        }

        $nextSyncToken = str_replace('=ok', '', $gCal->events->listEvents($gCalendarID)
            ->getNextSyncToken());

        $calendar->sync_token = $nextSyncToken;
        $calendar->last_synced_at = new DateTime();
        $calendar->save();

        return ['message' => 'Calendars successfully synced'];
    }

    public function updateGEventByEventID(int $id)
    {
        $this->client->setAccessToken(session('g_cal_token'));

        $event = Event::where('id', $id)->first();
        $calendar = $event->calendar;
        $gCalendarID = $calendar->g_calendar_id;
        $baseTimezone = env('APP_TIMEZONE');

        $gCal = new Google_Service_Calendar($this->client);
        $this->updateGEvent($gCal, $gCalendarID, $event, $baseTimezone);

        $calendar->last_synced_at = new DateTime();
        $calendar->save();
    }

    /**
     * @param Google_Service_Calendar $gCal
     * @param $gCalendarID
     * @param $event
     * @param mixed $baseTimezone
     * @return void
     * @throws Exception
     */
    public function updateGEvent(Google_Service_Calendar $gCal, $gCalendarID, $event, mixed $baseTimezone): void
    {
        $gEvent = $gCal->events->get($gCalendarID, $event->g_event_id);

        $startDateTime = Carbon::parse($event->datetime_start, $baseTimezone);

        $endDateTime = Carbon::parse($event->datetime_end, $baseTimezone);

        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime($startDateTime->toAtomString());
        $gEvent->setStart($start);

        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime($endDateTime->toAtomString());
        $gEvent->setEnd($end);

        $gEvent->setSummary($event->title);

        $gCal->events->update($gCalendarID, $event->g_event_id, $gEvent);
    }

    public function getCalendarID($userID)
    {
        return User::where('id', $userID)->first()->hrable->calendar->g_calendar_id;
    }

    public function getAvailableSlotsInMonth(int $accountable_id, string $month): array
    {
        $calendar = Calendar::where('hr_id', $accountable_id)->first();

        $startOfMonth = DateTime::createFromFormat('Y-m-d', $month, new DateTimeZone("Asia/Novosibirsk"));
        if (new DateTime() > $startOfMonth) {
            $startOfMonth = new DateTime(timezone: new DateTimeZone("Asia/Novosibirsk"));
        }

        $endOfMonth = DateTime::createFromFormat("Y-m-d", date("Y-m-t", strtotime($month)), new DateTimeZone("Asia/Novosibirsk"));
        $events = Event::where('calendar_id', $calendar->id)
            ->where('datetime_start', '>', $startOfMonth)
            ->where('datetime_end', '<', $endOfMonth)
            ->where('is_picked', false)->get();
        $calendar = [];
        $startOfDay = DateTime::createFromFormat('Y-m-d', $month, new DateTimeZone("Asia/Novosibirsk"));
        for ($i = 0; $i <= (int)$endOfMonth->format("t") - 1; $i++) {
            $endOfDay = clone $startOfDay;
            $startOfDay = Carbon::create($startOfDay)->startOfDay();
            $endOfDay = Carbon::create($endOfDay)->endOfDay();
            $calendar[$i + 1] = [];

            $sortedEvents = $events
                ->where('datetime_start', '>', $startOfDay)
                ->where('datetime_end', '<', $endOfDay)
                ->select('datetime_start', 'id')->toArray();

            usort($sortedEvents, function ($a, $b) {
                return $a['datetime_start'] > $b['datetime_start'];
            });


            $calendar[$i + 1][] = $sortedEvents;

            $startOfDay = $startOfDay->modify('+1 days');
        }

        return $calendar;
    }

    public function bookSlot(int $eventID)
    {
        $event = Event::where('id', $eventID)->first();
        $event->is_picked = true;
        $event->save();

        return ['message' => 'Event booked'];
    }

    public function downloadICS(): bool|string
    {
        $this->client->setAccessToken(auth()->user()->hrable->token);

        $calendar = Calendar::where('hr_id', auth()->user()->hrable->id)->first();

        $gCalendarID = $calendar->g_calendar_id;
        $gCal = new Google_Service_Calendar($this->client);

        $rule = new AclRule();
        $scope = new AclRuleScope();

        $scope->setType("default");
        $scope->setValue("");
        $rule->setScope($scope);
        $rule->setRole("reader");

        $createdRule = $gCal->acl->insert($gCalendarID, $rule);

        $iCS = file_get_contents('https://www.google.com/calendar/ical/'.$gCalendarID.'/public/basic.ics');
        $gCal->acl->delete($gCalendarID, $createdRule->getId());

        return $iCS;
    }
}
