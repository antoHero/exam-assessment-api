<?php

namespace App\Services\Assessment;

use App\Http\Requests\StoreQuestionRequest;
use App\Models\{Assessment, Question};
use Illuminate\Support\Facades\DB;

class QuestionService {

    /**
     * create a question
     * @param \App\Http\Requests\StoreQuestionRequest|array $request
     * @param \App\Models\Assessment $assessment
     * @return \App\Models\Question
    */
    public function create_question(StoreQuestionRequest|array $request, Assessment $assessment): Question
    {
        return DB::transaction(function () use ($request, $assessment) {
            return $assessment->questions()->create($request);
        });
    }
}