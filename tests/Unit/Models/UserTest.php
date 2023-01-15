<?php

namespace Tests\Unit\Model;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    
    use RefreshDatabase;

    public function testBelongsToUserType()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(UserType::class, $user->user_type);
    }
}
