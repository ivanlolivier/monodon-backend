<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

use App\Http\Requests;

class QuestionController extends _Controller
{
    public function index()
    {
        $this->authorize('index', Question::class);

        $questions = Question::all();

        return $this->responseAsJson($questions, 200, Question::transformer());
    }
}
