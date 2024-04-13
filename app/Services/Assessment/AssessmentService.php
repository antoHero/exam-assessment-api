<?php

namespace App\Services\Assessment;

use App\Http\Requests\StoreAssessmentRequest;
use App\Models\Assessment;
use Illuminate\Support\Facades\DB;

class AssessmentService
{
    /**
     * create an assessment
     * @param App\Http\Requests\StoreAssessmentRequest|array $request
     * @return App\Model\Assessment
    */

    public function create_assessment(StoreAssessmentRequest|array $request): Assessment
    {
        return DB::transaction(function () use($request) {
            return Assessment::create([
                'user_id' => auth()->id(),
                'title' => $request['title'],
                'instructions' => $request['instructions'],
                'date' => $request['date'],
                'duration' => $request['duration'],
                'expected_score' => $request['expected_score'],
            ]);
        });
    }
}