<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\BookConfirmationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmationEmail
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

        Mail::to($book->user_email)->queue(new BookConfirmationEmail($book));
    }
}
