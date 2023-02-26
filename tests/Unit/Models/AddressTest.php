<?php

namespace Tests\Unit\Models;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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

    public function testHasManyShippings(): void
    {
        $address = New Address();

        $this->assertInstanceOf(Collection::class, $address->shippings);
    }
}
