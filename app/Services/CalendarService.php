<?php

namespace App\Services;

use App\Google;
use App\Models\Calendar;
use App\Models\Event;
use Carbon\Carbon;
use DateTime;
use Google\Service\Exception;
use Google\Service\HangoutsChat;
use Google_Service_Calendar;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_ConferenceData;
use Google_Service_Calendar_ConferenceSolutionKey;
use Google_Service_Calendar_CreateConferenceRequest;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Illuminate\Http\Request;

class CalendarService
{

    private $client;

    public function __construct(protected Google $google)
    {
        $this->client = $this->google->client();
    }

    public function loginWithGoogle($user, $code)
    {
        $client = $this->google->client();

        $token = $client->fetchAccessTokenWithAuthCode($code);

        $client->setAccessToken($token);

        $hr = $user->hrable;

        if ($hr->token == null) {
            $hr->token = json_encode($token);
            $hr->save();

            $calendar = new Calendar;
            $calendar->hr_id = $hr->id;
            $calendar->title = 'Venari. Календарь пользователя ' . $hr->user->first_name . " " . $hr->user->last_name;
            $calendar->g_calendar_id = 'Venari. Календарь пользователя ' . $hr->user->first_name . " " . $hr->user->last_name;
            $calendar->sync_token = '';
            $calendar->save();
            $this->createGCalendar($calendar);

        } else {
            $calendar = Calendar::where('hr_id', $hr->id)->first();
        }

        session([
            'g_cal_token' => $token
        ]);

        return ['message' => 'successfully authenticated with Google'];
    }

    public function createRedirectUrl()
    {
        $auth_url = $this->client->createAuthUrl();

        return ['message' => $auth_url];
    }

    private function createGCalendar(Calendar $calendar)
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

        $calendar->g_calendar_id = $created_calendar->getId();;
        $calendar->save();

        return $calendar->toArray();
    }

    public function createGEvent(Event $event, bool $isMeet)
    {
        // todo: добавить валидацию запроса
//        $this->validate($request, [
//            'title' => 'required',
//            'calendar_id' => 'required',
//            'datetime_start' => 'required|date',
//            'datetime_end' => 'required|date'
//        ]);
        $this->client->setAccessToken(session('g_cal_token'));

        $startDateTime = Carbon::createFromFormat('Y/m/d H:i', $event->datetime_start->format('Y/m/d H:i'));
        $endDateTime = Carbon::createFromFormat('Y/m/d H:i', $event->datetime_end->format('Y/m/d H:i'));

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
        // todo
//        $this->validate($request, [
//            'calendar_id' => 'required'
//        ]);
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
                $calendar->save();

                break;
            }
        }
    }

    public function syncGFromCalendar(int $calendarId)
    {
        // todo
//        $this->validate($request, [
//            'calendar_id' => 'required'
//        ]);
        $this->client->setAccessToken(session('g_cal_token'));

        $baseTimezone = env('APP_TIMEZONE');
        $calendar = Calendar::find($calendarId);
        $gCalendarID = $calendar->g_calendar_id;

        $gCal = new Google_Service_Calendar($this->client);

        $events = Event::where('updated_at', '>', $calendar->last_synced_at)->get();

        foreach ($events as $event) {
            $this->updateGEvent($gCal, $gCalendarID, $event, $baseTimezone);
        }

        $calendar->last_synced_at = new DateTime();
        $calendar->save();
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
}
