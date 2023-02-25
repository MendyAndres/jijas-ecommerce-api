<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    
    use RefreshDatabase;

    public function testBelongsToUserType(): void
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(UserType::class, $user->user_type);
    }

    public function testHasManyAddresses(): void
    {
        $user = new User();

        $this->assertInstanceOf(Collection::class, $user->addresses);
    }

    public function testHasManyFeedbacks(): void
    {
        $user = new User();

        $this->assertInstanceOf(Collection::class, $user->feedbacks);
    }

    public function testHasManyCarts(): void
    {
        $user = new User();

        $this->assertInstanceOf(Collection::class, $user->carts);
    }
}
