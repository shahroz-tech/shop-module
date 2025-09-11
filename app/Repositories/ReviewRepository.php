<?php

namespace App\Repositories;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewRepository
{
    public function getReviews(){
        return Review::with('product','user')->where('user_id',Auth::user()->id)->get();
    }

    public function create(array $data)
    {
        $review = Review::create([
            'product_id' => $data['product_id'],
            'user_id'    => Auth::id(),
            'review'     => $data['review'],
        ]);

        return $review->load(['product', 'user']);
    }

}
