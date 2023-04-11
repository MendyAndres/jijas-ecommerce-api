<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserTypeSeeder;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Laravel\Passport\ClientRepository;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            'http://localhost'
        );

        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
           ]);
    }

    public function testRegistration()
    {

        $userTypeSeeder = new UserTypeSeeder();
        $userTypeSeeder->run();

        $header['Accept'] = 'application/json';

        $response = $this->post('api/register',
        [
            'first_name' => 'Stephanie',
            'last_name' => 'Lezama',
            'document' => '95832002',
            'birthdate' => '1995-04-27',
            'email' => 'prueba3@prueba.com',
            'password' => 'Password1.',
            'password_confirmation' => 'Password1.',
            'user_type_id' => '1'
        ], $header);

        $response->assertStatus(200);
        $this->assertArrayHasKey('authToken', $response->json());
    }

    public function testLoginAndLogout(): void
    {
        $header['Accept'] = 'application/json';
        $user = User::factory()->create();

        $response = $this->post('api/login',
        [
            'email' => $user->email,
            'password' => 'Password1.',
        ], $header);

        $response->assertStatus(200);
        $this->assertArrayHasKey('authToken', $response->json());

        $token = "Bearer " . $response['authToken'];
        $header['Authorization'] = $token;
        $response = $this->post('/api/logout', [], $header);
        $response->assertStatus(200);

    }
}