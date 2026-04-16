<?php

namespace App\Listeners;

use App\Mail\SeriesCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\SeriesCreated as SeriesCreatedEvent;

class EmailUsersAboutSeriesCreated implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SeriesCreatedEvent $event)
    {
        $userList = User::all();
        foreach ($userList as $user) {

            $email = new SeriesCreated(
                (string) $event->seriesName,
                (int) $event->seriesId,
                (int) $event->seriesSeasonQty,
                (int) $event->seriesEpisodesPerSeason,
            );

            Mail::to($user)->send($email);
        }
    }
}
