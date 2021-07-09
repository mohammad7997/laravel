<?php

use App\Http\Controllers\Api\v1\Channel\ChannelController;
use Tests\TestCase;
use \App\Models\Channel;
use \Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Models\User;
use \Laravel\Sanctum\Sanctum;
use \Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ChannelTest extends TestCase
{
    use RefreshDatabase;

    public function RoleAndPermission()
    {

        $roles = Role::where('name', config('permission.default_roles')[0]);
        if ($roles->count() < 1) {
            foreach (config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role
                ]);
            }
        }

        $permissionInDatabases = Permission::where('name', config('permission.default_permission')[0]);
        if ($permissionInDatabases->count() < 1) {
            foreach (config('permission.default_permission') as $permissionInDatabase) {
                Permission::create([
                    'name' => $permissionInDatabase
                ]);
            }
        }
    }


    public function test_get_all_list_of_channel()
    {
        $response = $this->json('get', route('Channel.getList'));
        $response->assertStatus(200);
    }

    public function test_create_channel_validate()
    {
        $this->RoleAndPermission();
        $userFactory = User::factory()->create();
        $userFactory->givePermissionTo('channel management');
        Sanctum::actingAs($userFactory);

        $response = $this->postJson(route('Channel.create'));
        $response->assertStatus(422);
    }

    public function test_create_new_channel()
    {
        $this->RoleAndPermission();
        $userFactory = User::factory()->create();
        $userFactory->givePermissionTo('channel management');
        Sanctum::actingAs($userFactory);

        $resposnse = $this->postJson(route('Channel.create', [
            'name' => 'laravel'
        ]));

        $resposnse->assertStatus(201);
    }


    public function test_update_channel_validate()
    {
        $this->RoleAndPermission();
        $userFactory = User::factory()->create();
        $userFactory->givePermissionTo('channel management');
        Sanctum::actingAs($userFactory);

        $channel = Channel::factory()->create();
        $response = $this->json('put', route('Channel.update', $channel->id));
        $response->assertStatus(422);
    }

    public function test_update_channel()
    {
        $this->RoleAndPermission();
        $userFactory = User::factory()->create();
        $userFactory->givePermissionTo('channel management');
        Sanctum::actingAs($userFactory);

        $channel = Channel::factory()->create();
        $response = $this->json('put', route('Channel.update', $channel->id), [
            'name' => 'laravel2'
        ]);

        //$channelUpdated=\App\Models\Channel::find($channel->id);

        $response->assertStatus(200);
        //$response->assert('laravel2',$channelUpdated->name);
    }

    public function test_delete_channel()
    {
        $this->RoleAndPermission();
        $userFactory = User::factory()->create();
        $userFactory->givePermissionTo('channel management');
        Sanctum::actingAs($userFactory);

        $channel = Channel::factory()->create();
        $response = $this->json('delete', route('Channel.delete', $channel->id));
        $response->assertStatus(200);
    }


}
