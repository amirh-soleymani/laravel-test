<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\BookNotificationAdminEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyAdminOfBooking
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        $book = $event->book;

        Mail::to('royal.falconalex@gmail.com')->queue(new BookNotificationAdminEmail($book));
    }
}
