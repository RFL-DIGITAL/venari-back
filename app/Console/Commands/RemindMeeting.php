<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\Notification;
use Carbon\Carbon;
use DateTime;
use Illuminate\Console\Command;

class RemindMeeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-meeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::where('datetime_start', '>',
            new DateTime(timezone: new \DateTimeZone('Asia/Novosibirsk')))
            ->where('datetime_end', '<', Carbon::now()->endOfDay())->get();

        foreach ($events as $event) {
            if (date_diff($event->datetime_start,
                    new DateTime(timezone: new \DateTimeZone('Asia/Novosibirsk')))->m < 30
            and !$event->is_reminded) {
                $notificationForUser = new Notification();
                $notificationForUser->text = 'Напоминаем вам о том, что менее через полчаса у вас назначена встреча.
                Дата и время: '.date('H:i d.m.Y', strtotime($event->datetime_start)).'
                Ссылка на Google Meet: '.$event->meet_link;
                $notificationForUser->user_id = $event->user_id;
                $notificationForUser->save();

                $notificationForHR = new Notification();
                $notificationForHR->text = 'Напоминаем вам о том, что менее через полчаса у вас назначена встреча.
                Дата и время: '.date('H:i d.m.Y', strtotime($event->datetime_start)).'
                Ссылка на Google Meet: '.$event->meet_link;
                $notificationForHR->user_id = $event->calendar->hr->user->id;
                $notificationForHR->save();

                $event->is_reminded = true;
            }
        }
    }
}
