<?php

namespace App\Http\Controllers\Api\V1\Answer;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Thread;
use App\Repository\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use \Illuminate\Http\JsonResponse;

class AnswerController extends Controller
{

    /**
     * all answer
     * @return JsonResponse
     */
    public function index()
    {
        $allAnswer = resolve(AnswerRepository::class)->allAnswer();

        return response()->json($allAnswer, Response::HTTP_OK);
    }


    /**
     * create answer for thread
     * @param Request $request
     * @param Thread $thread
     * @return JsonResponse
     */
    public function store(Request $request, Thread $thread)
    {
        $request->validate([
            'content' => 'required',
        ]);

        resolve(AnswerRepository::class)->createAnswer($thread, $request);

        return response()->json([
            'message' => 'create answer successfully'
        ], Response::HTTP_CREATED);
    }


    /**
     * update answer with user who created
     * @param Request $request
     * @param Answer $answer
     * @return JsonResponse
     */
    public function update(Request $request, Answer $answer)
    {
        //
        $request->validate([
            'content' => 'required',
            'user_id'=> 'required'
        ]);

        if ($answer->user_id==$request->user_id) {

            resolve(AnswerRepository::class)->updateAnswer($answer,$request);

            return response()->json([
                'message' => 'update answer successfully',
            ], Response::HTTP_OK);
        }

        return response()->json([
            'message' => 'update answer failed',
        ],Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
