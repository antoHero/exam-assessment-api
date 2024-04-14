<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\AnswerResource;
use App\Models\{Assessment, Question};
use App\Services\Assessment\QuestionService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AnswerController extends BaseController
{
    public function __construct(
        public QuestionService $questionService
    ){}

    public function index(Question $question): JsonResponse
    {
        return $this->ok(AnswerResource::collection($question->answers) ?? null, 'Answers retrieved successfully', Response::HTTP_OK);
    }

    public function userAnswers(Question $question)
    {
        $question = Question::whereHas('assessment', function($assessment) use($question) {
            $assessment->whereId($question->assessment->id)->whereUserId(auth()->user()->id);
        })->first();
        return $this->ok(AnswerResource::collection($question->answers) ?? null, 'User answers to question retrieved successfully', Response::HTTP_OK);
    }
}
