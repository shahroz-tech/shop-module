<?php

namespace App\Services;

use App\Repositories\ReviewRepository;

class ReviewService
{
    protected ReviewRepository $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository){
        $this->reviewRepository = $reviewRepository;
    }

    public function getReviews(){
        return $this->reviewRepository->getReviews();
    }

    public function store(array $data){
        return $this->reviewRepository->create($data);
    }

}
