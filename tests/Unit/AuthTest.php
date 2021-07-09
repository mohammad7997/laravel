<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use \Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use \Illuminate\Http\Response;


class AuthTest extends TestCase
{

    use RefreshDatabase;
    public function RoleAndPermission()
    {

        $roles = Role::where('name', config('permission.default_roles')[0]);
        if ($roles->count() < 1) {
            foreach (config('permission.default_roles') as $role){
                Role::create([
                    'name'=>$role
                ]);
            }
        }

        $permissionInDatabases = Permission::where('name', config('permission.default_permission')[0]);
        if ($permissionInDatabases->count() < 1) {
            foreach (config('permission.default_permission') as $permissionInDatabase){
                Permission::create([
                    'name'=>$permissionInDatabase
                ]);
            }
        }
    }

    public function test_register_should_be_validate()
    {

        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_register_new_user()
    {
        $this->RoleAndPermission();
        $response = $this->postJson(route('auth.register', [
            'name'=>'mohammad',
            'email'=>'mjharahi1379@gmail.com',
            'password'=>'password'
        ]));
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_login_should_be_validate()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_login_user()
    {

        $userFactory=\App\Models\User::factory()->create();
        $response = $this->postJson(route('auth.login', [
            'email'=>$userFactory->email,
            'password'=>'password'
        ]));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_show_info_user_login()
    {
        $userFactory=\App\Models\User::factory()->create();
        $response = $this->actingAs($userFactory)->postJson(route('auth.showInfo'));
        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_user_login_can_logged_out()
    {
        $userFactory=\App\Models\User::factory()->create();
        $response = $this->actingAs($userFactory)->postJson(route('auth.logout'));
        $response->assertStatus(Response::HTTP_OK);
    }
}
