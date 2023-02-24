<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;
use App\Models\Feedback;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser(): void
    {
        $feedback = Feedback::factory()->create();

        $this->assertInstanceOf(User::class, $feedback->user);
    }

    public function testBelongsToProduct(): void
    {
        $feedback = Feedback::factory()->create();

        $this->assertInstanceOf(Product::class, $feedback->product);
    }
}
