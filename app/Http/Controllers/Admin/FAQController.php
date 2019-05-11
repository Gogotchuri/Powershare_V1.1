<?php

namespace App\Http\Controllers\Admin;

use App\Models\FaqQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $questions = FaqQuestion::all()
            ->sortByDesc(
            function ($q){
                return $q->frequency;
            });

        return self::responseData($questions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            "answer" => ["required", "min:3", "max:500"],
            "question" => ["required", "min:5", "string", "max:100"],
            "frequency" => ["numerical"]
        ]);

        if($validator->fails())
            return self::responseErrors($validator->errors(), 422);

        $question = new FaqQuestion();
        $question->question = $request["question"];
        $question->answer = $request["answer"];
        if($request["frequency"] != null)
            $question->frequency = $request["frequency"];
        $question->save();

        return self::responseData($question, 201);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $question = FaqQuestion::Where("id", $id)->first();
        if($question == null)
            return self::responseErrors("Question not found!", 404);
        return self::responseData($question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            "answer" => ["min:3", "max:500"],
            "question" => ["min:5", "string", "max:100"],
            "frequency" => ["numerical"]
        ]);

        if($validator->fails())
            return self::responseErrors($validator->errors(), 422);

        $question = FaqQuestion::Where("id", $id)->first();
        if($question == null)
            return self::responseErrors("Question not found!", 404);

        if($request["question"] != null)
            $question->question = $request["question"];
        if($request["answer"] != null)
            $question->answer = $request["answer"];
        if($request["frequency"] != null)
            $question->frequency = $request["frequency"];
        $question->save();

        return self::responseData($question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $question = FaqQuestion::Where("id", $id)->first();
        if($question == null)
            return self::responseErrors("Question not found!", 404);
        return self::responseData("Deleted!");
    }
}
