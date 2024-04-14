<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Base\BaseController;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Resources\{OptionResource};
use App\Models\{Question};
use App\Services\Assessment\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionController extends BaseController
{
    public function __construct(
        public QuestionService $questionService
    ){}

    public function index(Question $question): JsonResponse
    {
        if($question->options === null) {
            return $this->ok(null, 'Options successfully retrieved', Response::HTTP_OK);
        }
        return $this->ok(OptionResource::collection($question->options), 'Options successfully retrieved', Response::HTTP_OK);
    }

    public function store(StoreOptionRequest $request, Question $question): JsonResponse
    {
        $request = $request->only(['content', 'isAnswer']);
        $option = $this->questionService->create_option($request, $question);
        return $this->ok(new OptionResource($option), 'Options successfully created', Response::HTTP_CREATED);
    }
}
