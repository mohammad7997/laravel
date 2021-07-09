<?php


namespace App\Repository;


use App\Models\Answer;
use App\Models\Thread;

class AnswerRepository
{

    /**
     * @return Answer[]|\Illuminate\Database\Eloquent\Collection
     */
    public function allAnswer()
    {
        return Answer::all();
    }


    /**
     * create answer
     * @param $thread
     * @param $request
     */
    public function createAnswer($thread, $request)
    {
        $thread->answers()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id
        ]);
    }


    /**
     * update answer
     * @param $answer
     * @param $request
     */
    public function updateAnswer($answer, $request)
    {
        $answer->update([
            'content'=>$request->input('content'),
        ]);
    }
}
