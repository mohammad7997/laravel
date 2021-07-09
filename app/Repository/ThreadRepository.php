<?php


namespace App\Repository;


use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ThreadRepository
{


    /**
     * show all threads
     * @return mixed
     */
    public function AllThreads()
    {

        return Thread::whereFlag(1)->latest()->get();
    }

    /**
     * show thread with slug
     * @param $slug
     * @return mixed
     */
    public function Thread($slug)
    {
        $allThreads = Thread::whereFlag(1)->whereSlug($slug)->first();
        return $allThreads;
    }


    /**
     * create thread
     * @param Request $request
     */
    public function createThread(Request $request)
    {
        Thread::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id,
            'channel_id' => $request->input('channel_id')
        ]);
    }

    /**
     * update thread
     * @param $request
     * @param $thread
     */
    public function updateThread($request, $thread)
    {
        $thread->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'content' => $request->input('content'),
            'channel_id' => $request->input('channel_id')
        ]);
    }


    /**
     * @param Thread $thread
     * @param Request $request
     */
    public function bestAnswerUpdate($thread, $request)
    {
        $thread->update([
            'best_answer_id' => $request->best_answer,
        ]);
    }

    /**
     * @param $thread
     */
    public function deleteThread($thread)
    {
        $thread->delete();
    }
}
