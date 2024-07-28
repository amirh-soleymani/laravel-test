<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityImageUploadRequest;
use App\Http\Requests\ActivityRequest;
use App\Http\Requests\ActivitySearchRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::all();

        return Response::successResponse('Done', ActivityResource::collection($activities));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityRequest $activityRequest)
    {
        $activity = Activity::create([
            'name' => $activityRequest->name,
            'description' => $activityRequest->description,
            'location' => $activityRequest->location,
            'price' => $activityRequest->price,
            'available_slots'=> $activityRequest->available_slots,
            'start_date' => $activityRequest->start_date
        ]);

        return Response::successResponse('Activity Created Successfully', ActivityResource::make($activity));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activity = Activity::find($id);

        return Response::successResponse('Done', ActivityResource::make($activity));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityRequest $activityRequest, string $id)
    {
        $activity = Activity::find($id);

        $activity->name = $activityRequest->name;
        $activity->description = $activityRequest->description;
        $activity->location = $activityRequest->location;
        $activity->price = $activityRequest->price;
        $activity->available_slots = $activityRequest->available_slots;
        $activity->start_date = $activityRequest->start_date;
        $activity->save();

        return Response::successResponse('Activity Updated Successfully', ActivityResource::make($activity));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = Activity::find($id);
        $activity->delete();

        return Response::successResponse('Activity Deleted SuccessFully', []);
    }

    public function upload(ActivityImageUploadRequest $activityImageUploadRequest)
    {
        $imageRequest = $activityImageUploadRequest->file('image');
        $activity = Activity::find($activityImageUploadRequest->activity_id);

        $imageExtension = $activityImageUploadRequest->image->getClientOriginalExtension();
        $imageName = time() . '.' . $imageExtension;
        $imageRequest->storeAs('images', $imageName);

        $image = new Image();
        $image->path = '/uploads/activityImages/' . $imageName;
        $activity->images()->save($image);

        return Response::successResponse('Activity Image Uploaded Successfully', ActivityResource::make($activity));
    }

    public function search(ActivitySearchRequest $activitySearchRequest)
    {
        $name = $activitySearchRequest->name;
        $location = $activitySearchRequest->location;
        $minPrice = $activitySearchRequest->minPrice ?? 1;
        $maxPrice = $activitySearchRequest->maxPrice ?? 999999999;

        $activities = Activity::where([
            ['name', 'like', '%' . $name . '%'],
            ['location', 'like', '%' . $location . '%'],
        ])
            ->whereBetween('price' ,[$minPrice, $maxPrice])
            ->get()
            ->sortByDesc('available_slots');


        return Response::successResponse('Done', ActivityResource::collection($activities));
    }
}
