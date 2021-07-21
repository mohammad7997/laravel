<?php

use App\Http\Controllers\Api\V1\Answer\AnswerController;
use Tests\TestCase;
use \App\Models\Answer;
use \Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Http\Response;
use \App\Models\Thread;
use \App\Models\User;
use \Laravel\Sanctum\Sanctum;

class AnswerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function get_all_answer()
    {
        Answer::factory()->count(10)->create();
        $response = $this->getJson(route('Answer.all'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    public function create_answer_should_be_validate()
    {
        $threadFactory = Thread::factory()->create();
        $response = $this->postJson(route('Answer.store', $threadFactory->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content']);
    }

    /** @test */
    public function create_answer_for_thread()
    {
        $threadFactory = Thread::factory()->create();
        $answerFactory = Answer::factory()->create();
        $userFactory = User::factory()->create();
        Sanctum::actingAs($userFactory);
        $response = $this->postJson(route('Answer.store', $threadFactory->id), [
            'content' => $answerFactory->content,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /** @test */

    public function update_answer_can_be_validate()
    {
        $answerFactory = Answer::factory()->create();

        $response = $this->postJson(route('Answer.update', $answerFactory->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['content', 'user_id']);

    }

    /** @test */

    public function can_update_answer_who_created()
    {
        $userFactory = User::factory()->create();
        $threadFactory = Thread::factory()->create();
        $answerFactory = Answer::factory()->create([
            'user_id' => $userFactory->id,
            'thread_id' => $threadFactory->id,
        ]);

        $response = $this->postJson(route('Answer.update', $answerFactory->id), [
            'content' => 'foo',
            'user_id' => $userFactory->id + 1,
        ]);
        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /** @test */

    public function can_update_answer_with_user_created()
    {

        $userFactory = User::factory()->create();
        Sanctum::actingAs($userFactory);
        $threadFactory = Thread::factory()->create();
        $answerFactory = Answer::factory()->create([
            'user_id' => $userFactory->id,
            'thread_id' => $threadFactory->id,
        ]);

        $response = $this->postJson(route('Answer.update', $answerFactory->id), [
            'content' => 'foo',
            'user_id' => $userFactory->id,
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }


    /** @test */
    public function can_own_delete_answer()
    {
        $userFactory = User::factory()->create();
        Sanctum::actingAs($userFactory);

        $answerFactory = Answer::factory()->create([
            'user_id' => $userFactory->id,
        ]);

        $response = $this->deleteJson(route('Answer.delete', $answerFactory->id));
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'message' => 'delete answer successfully'
        ]);
    }

}
