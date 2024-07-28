<?php

namespace App\Http\Controllers;

use App\Events\BookingCreated;
use App\Http\Requests\BookActivityRequest;
use App\Http\Resources\BookResource;
use App\Mail\BookConfirmationEmail;
use App\Mail\BookNotificationAdminEmail;
use App\Models\Activity;
use App\Models\Book;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookController extends Controller
{
    public function bookActivity(BookActivityRequest $bookActivityRequest)
    {
        $activity = Activity::find($bookActivityRequest->activity_id);
        $userName = $bookActivityRequest->user_name;
        $userEmail = $bookActivityRequest->user_email;
        $slotsBooked = $bookActivityRequest->slots_booked;

        if ($activity->available_slots < $slotsBooked) {
            return Response::errorResponse('There is not enough slots for this Activity',[],400);
        }

        $book = DB::transaction(function () use($activity, $userName, $userEmail, $slotsBooked)
        {
            $book = Book::create([
                'activity_id' => $activity->id,
                'user_name' => $userName,
                'user_email' => $userEmail,
                'slots_booked' => $slotsBooked,
                'status' => 'pending'
            ]);
            
            $activity->available_slots =  $activity->available_slots - $slotsBooked;
            $activity->save();

            return $book;
        });

        event(new BookingCreated($book));

        $book->status = 'confirmed';
        $book->save();

        return Response::successResponse('Activity Booked Successfully', BookResource::make($book));
    }

    public function cancelActivity()
    {


    }
}
