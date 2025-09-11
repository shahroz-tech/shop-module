<?php

namespace App\Http\Controllers\ReviewController;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest\AddReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Services\ReviewService\ReviewService;

class ReviewController extends Controller
{
    protected ReviewService  $reviewService;
    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function getReviews(){
        $reviews = $this->reviewService->getReviews();
        return ReviewResource::collection($reviews);
    }

    public function addReview(AddReviewRequest $request){
        $review = $this->reviewService->store($request->validated());


        return back()->with('success', 'Review added successfully!');
    }
}
