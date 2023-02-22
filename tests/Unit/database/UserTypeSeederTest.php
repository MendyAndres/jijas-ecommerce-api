<?php

namespace Tests\Unit\database;

use Database\Seeders\UserTypeSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTypeSeederTest extends TestCase
{

    use RefreshDatabase;

    public function testDidTheUserTypeSeederRun()
    {
        $userTypeSeeder = new UserTypeSeeder();
        $userTypeSeeder->run();
        $this->assertDatabaseHas('user_types', [
                'cod' => 'ADMIN'
        ]);
        $this->assertDatabaseHas('user_types', [
                'cod' => 'SALES'
        ]);
    }
}
