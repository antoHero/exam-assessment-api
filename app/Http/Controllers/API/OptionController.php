<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Base\BaseController;
use App\Http\Resources\{OptionResource};
use App\Models\{Question};
use App\Services\Assessment\QuestionService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptionController extends BaseController
{
    public function __construct(
        public QuestionService $questionService
    ){}

    public function index(Question $question)
    {
        if($question->options === null) {
            return $this->ok(null, 'Options successfully retrieved', Response::HTTP_OK);
        }
        return $this->ok(OptionResource::collection($question->options), 'Options successfully retrieved', Response::HTTP_OK);
    }
}
