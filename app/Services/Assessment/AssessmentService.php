<?php

namespace App\Services\Assessment;

use App\Http\Requests\{StoreAssessmentRequest, UpdateAssessmentRequest};
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

    /**
     * create an assessment
     * @param App\Http\Requests\StoreAssessmentRequest|array $request
     * @param App\Model\Assessment $assessment
     * @return bool
    */

    public function update_assessment(UpdateAssessmentRequest|array $request, Assessment $assessment): bool
    {
        return DB::transaction(function () use($request, $assessment) {
            return $assessment->update([
                'title' => $request['title'] ?? $assessment->title,
                'instructions' => $request['instructions'] ?? $assessment->instructions,
                'date' => $request['date'] ?? $assessment->date,
                'duration' => $request['duration'] ?? $assessment->duration,
                'expected_score' => $request['expected_score'] ?? $assessment->expected_score,
            ]);
        });
    }
}