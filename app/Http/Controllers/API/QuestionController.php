<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Assessment;
use App\Services\Assessment\QuestionService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends BaseController
{
    public function __construct(
        public QuestionService $questionService
    ){}

    public function store(StoreQuestionRequest $request, Assessment $assessment): JsonResponse
    {
        $question = $this->questionService->create_question($request->validated(), $assessment);
        return $this->ok(new QuestionResource($question), 'Question successfully created.', Response::HTTP_CREATED);
    }
}