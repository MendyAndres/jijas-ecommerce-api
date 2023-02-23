<?php

namespace Tests\Unit\Models;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser(): void
    {
        $address = Address::factory()->create();

        $this->assertInstanceOf(User::class, $address->user);
    }
}
