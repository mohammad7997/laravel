<?php

use App\Http\Controllers\Api\V1\Thread\ThreadController;
use Tests\TestCase;
use \App\Models\Thread;
use App\Models\User;
use \Laravel\Sanctum\Sanctum;
use \Illuminate\Http\Response;
use \App\Models\Channel;
use \App\Models\Answer;

class ThreadTest extends TestCase
{

    /** @test */
    public function show_all_threads()
    {
        //$this->withoutExceptionHandling();
        Thread::factory()->create();

        $response = $this->getJson(route('Thread.index'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function show_thread_with_slug()
    {
        $treadFactory = Thread::factory()->create();
        $response = $this->getJson(route('Thread.show', [$treadFactory->slug]));
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function can_create_new_thread()
    {


        $userFactory = User::factory()->create();
        Sanctum::actingAs($userFactory);

        $response = $this->postJson(route('Thread.store'), [
            'title' => 'laravel',
            'content' => 'test laravel',
            'channel_id' => \App\Models\Channel::factory()->create()->id,
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /** @test */
    public function for_update_thread_should_be_create_with_user()
    {
        $userFactory = User::factory()->create();
        Sanctum::actingAs($userFactory);

        $threadFactory = Thread::factory()->create();
        $response = $this->putJson(route('Thread.update', $threadFactory->id), [
            'title' => 'laravel',
            'content' => 'test laravel',
            'channel_id' => Channel::factory()->create()->id,
        ]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function can_update_thread()
    {
        $userFactory = User::factory()->create();
        Sanctum::actingAs($userFactory);

        $threadFactory = Thread::factory()->create([
            'user_id' => $userFactory->id
        ]);
        $response = $this->putJson(route('Thread.update', $threadFactory->id), [
            'title' => 'laravel',
            'content' => 'test laravel',
            'channel_id' => Channel::factory()->create()->id,
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function can_choose_best_answer()
    {
        $this->withoutExceptionHandling();
        $userFactory=User::factory()->create();
        Sanctum::actingAs($userFactory);
        $answerFactory=Answer::factory()->create();
        $threadFactory=Thread::factory()->create([
            'user_id'=>$userFactory->id
        ]);
        $response=$this->putJson(route('Thread.bestAnswer',$threadFactory->id),[
            'best_answer'=>$answerFactory->id,
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /** @test */
    public function for_delete_thread_should_be_create_with_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create();
        $response = $this->deleteJson(route('Thread.delete', $thread->id));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    public function can_delete_thread()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $thread = Thread::factory()->create([
            'user_id' => $user->id,
        ]);
        $response = $this->deleteJson(route('Thread.delete', $thread->id));
        $response->assertStatus(Response::HTTP_OK);
    }
}
