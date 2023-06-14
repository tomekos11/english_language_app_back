<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Entities\User;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_login_check()
    {
        Artisan::call('passport:install');
        $password = 'Test123#';
        $user = User::create([
            'email' => 'test@stormcode.pl',
            'password' => Hash::make($password)
        ]);
        $response = $this->post(route('auth.login'), ['email' => $user->email, 'password' => $password]);

        $response->assertStatus(200);
    }

    public function test_register_check()
    {
        Artisan::call('passport:install');
        $userData = [
            'email' => 'test@stormcode.pl',
            'password' => 'Test123#5695996',
            'name' => 'Tomasz',
            'surname' => 'Rzeźnikiewicz',
            'birth_date' => Carbon::parse('26-05-2000')->format('Y-m-d')
        ];
        $response = $this->post(route('auth.register'), $userData);

        $response->assertStatus(200);
    }

    public function test_logout_check()
    {
        Artisan::call('passport:install');
        $password = 'Test123#';
        $user = User::create([
            'email' => 'test@stormcode.pl',
            'password' => Hash::make($password)
        ]);
        $response = $this->post(route('auth.login'), ['email' => $user->email, 'password' => $password]);
        $content = $response->getContent();

        $response->assertStatus(200);
        $content = json_decode($content, true);
        $this->assertTrue($content['success']);
        $response = $this->get(route('auth.logout'), [
            'Authorization' => 'Bearer '.$content['data']['token']
        ]);
        $response->assertStatus(200);

        $content = $response->getContent();
        $content = json_decode($content, true);
        $this->assertTrue($content['success']);
    }
}
