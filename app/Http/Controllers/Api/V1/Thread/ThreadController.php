<?php

namespace App\Http\Controllers\Api\V1\Thread;

use App\Http\Controllers\Controller;
use App\Models\Thread;
use App\Repository\ThreadRepository;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ThreadController extends Controller
{

    /**
     * all threads
     * @return JsonResponse
     */
    public function index()
    {
        $threads = resolve(ThreadRepository::class)->AllThreads();
        return response()->json($threads, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * create new thread
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => ['required'],
            'content' => ['required'],
            'channel_id' => ['required'],
        ]);

        resolve(ThreadRepository::class)->createThread($request);

        return response()->json([
            'message' => 'create thread successfully'
        ], Response::HTTP_CREATED);

    }


    /**
     * show thread with slug
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug)
    {
        $thread = resolve(ThreadRepository::class)->Thread($slug);
        return response()->json($thread, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Request $request, Thread $thread)
    {
        //
        $request->validate([
            'title' => ['required'],
            'content' => ['required'],
            'channel_id' => ['required'],
        ]);
        if (Gate::forUser(Auth::user())->allows('UserAdminThread', $thread)) {
            resolve(ThreadRepository::class)->updateThread($request, $thread);

            return response()->json([
                'message' => 'update thread successfully'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'delete thread failed'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    /**
     * find best answer
     * @param Request $request
     * @param Thread $thread
     * @return JsonResponse
     */
    public function bestAnswerThread(Request $request, Thread $thread)
    {
        if (Gate::forUser(Auth::user())->allows('UserAdminThread', $thread)) {
            $request->validate([
                'best_answer' => ['required']
            ]);

            resolve(ThreadRepository::class)->bestAnswerUpdate($thread, $request);

            return response()->json([
                'message' => 'best answer was found for thread'
            ], Response::HTTP_OK);
        }
        return response()->json([
            'message' => 'cant update best answer for thread'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * delete thread
     * @param Thread $thread
     * @return JsonResponse
     */
    public function destroy(Thread $thread)
    {
        if (Gate::forUser(Auth::user())->allows('UserAdminThread', $thread)) {
            resolve(ThreadRepository::class)->deleteThread($thread);
            return \response()->json([
                'message' => 'delete thread successfully'
            ], Response::HTTP_OK);
        }
        return \response()->json([
            'message' => 'delete thread failed'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }


}
