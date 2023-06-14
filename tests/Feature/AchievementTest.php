<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;
use Modules\Auth\Enums\RoleEnum;
use Modules\System\Entities\Achievement;
use Tests\TestCase;

class AchievementTest extends TestCase
{
    use RefreshDatabase;

    public function test_achievement_creation_by_user()
    {
        Artisan::call('passport:install');
        $password = 'Test123#';
        $user = User::create([
            'email' => 'test@stormcode.pl',
            'password' => Hash::make($password)
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $response = $this->post(
            route('system.achievement.store'),
            [
                'name' => '50 dni nauki',
                'event_type' => 'streak',
                'value' => '50',
            ],
            [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(403);
    }

    public function test_achievement_creation_by_admin()
    {
        Artisan::call('passport:install');
        $password = 'Test123#';
        $user = User::create([
            'email' => 'test@stormcode.pl',
            'password' => Hash::make($password),
            'role' => RoleEnum::ADMIN,
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $response = $this->post(
            route('system.achievement.store'),
            [
                'name' => '50 dni nauki',
                'event_type' => 'streak',
                'value' => '50',
            ],
            [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(204);
        $response = $response->getOriginalContent();
        $this->assertTrue($response['success']);
        $achievementId = Achievement::first()->id;
        $this->assertEquals($achievementId, $response['data']['id']);
    }

    public function test_achievement_creation_by_none()
    {
        Artisan::call('passport:install');

        $response = $this->post(
            route('system.achievement.store'),
            [
                'name' => '50 dni nauki',
                'event_type' => 'streak',
                'value' => '50',
            ],
            [
                'Accept' => 'application/json'
            ]
        );
        $response->assertStatus(401);
    }

    public function test_achievement_update_by_user()
    {
        Artisan::call('passport:install');
        $password = 'Test123#';
        $user = User::create([
            'email' => 'test@stormcode.pl',
            'password' => Hash::make($password),
            'role' => RoleEnum::USER,
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $achievement = Achievement::create([
            'name' => '50 dni nauki',
            'event_type' => 'streak',
            'value' => '50',
        ]);

        $response = $this->patch(
            route('system.achievement.update', 1),
            [
                'name' => '25 rozwiązany test',
                'event_type' => 'passed_test',
                'value' => '25',
            ],
            [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json'
            ]
        );


        $response->assertStatus(403);
        $response = $response->getOriginalContent();
        $this->assertFalse($response['success']);
    }

    public function test_achievement_update_by_admin()
    {
        Artisan::call('passport:install');
        $password = 'Test123#';
        $user = User::create([
            'email' => 'test@stormcode.pl',
            'password' => Hash::make($password),
            'role' => RoleEnum::ADMIN,
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $achievement = Achievement::create([
            'name' => '50 dni nauki',
            'event_type' => 'streak',
            'value' => '50',
        ]);

        $response = $this->patch(
            route('system.achievement.update', 1),
            [
                'name' => '25 rozwiązany test',
                'event_type' => 'passed_test',
                'value' => '25',
            ],
            [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json'
            ]
        );


        $response->assertStatus(200);
        $response = $response->getOriginalContent();
        $this->assertTrue($response['success']);
        $achievementId = Achievement::first()->id;
        $this->assertEquals($achievementId, $response['data']['id']);
    }

    public function test_achievement_update_by_none()
    {
        Artisan::call('passport:install');

        $achievement = Achievement::create([
            'name' => '50 dni nauki',
            'event_type' => 'streak',
            'value' => '50',
        ]);

        $response = $this->patch(
            route('system.achievement.update', 1),
            [
                'name' => '25 rozwiązany test',
                'event_type' => 'passed_test',
                'value' => '25',
            ],
            [
                'Accept' => 'application/json'
            ]
        );


        $response->assertStatus(401);
    }

    public function test_achievement_delete_by_user()
    {
        Artisan::call('passport:install');
        $password = 'Test123#';
        $user = User::create([
            'email' => 'test@stormcode.pl',
            'password' => Hash::make($password),
            'role' => RoleEnum::USER,
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $achievement = Achievement::create([
            'name' => '50 dni nauki',
            'event_type' => 'streak',
            'value' => '50',
        ]);

        $response = $this->delete(
            route('system.achievement.update', 1),
            [],
            [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json'
            ]
        );


        $response->assertStatus(403);
        $response = $response->getOriginalContent();
        $this->assertFalse($response['success']);
    }

    public function test_achievement_delete_by_admin()
    {
        Artisan::call('passport:install');
        $password = 'Test123#';
        $user = User::create([
            'email' => 'test@stormcode.pl',
            'password' => Hash::make($password),
            'role' => RoleEnum::ADMIN,
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        $achievement = Achievement::create([
            'name' => '50 dni nauki',
            'event_type' => 'streak',
            'value' => '50',
        ]);

        $response = $this->delete(
            route('system.achievement.update', 1),
            [],
            [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json'
            ]
        );

        $response->assertStatus(200);
        $response = $response->getOriginalContent();

        $this->assertTrue($response['success']);
    }
    
    public function test_achievement_delete_by_none()
    {
        Artisan::call('passport:install');

        $achievement = Achievement::create([
            'name' => '50 dni nauki',
            'event_type' => 'streak',
            'value' => '50',
        ]);

        $response = $this->delete(
            route('system.achievement.delete', 1),
            [],
            [
                'Accept' => 'application/json'
            ]
        );


        $response->assertStatus(401);
    }
}
