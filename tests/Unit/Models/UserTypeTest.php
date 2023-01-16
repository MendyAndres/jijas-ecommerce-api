<?php

namespace Tests\Unit\Models;

use App\Models\UserType;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class UserTypeTest extends TestCase
{

    public function testHasManyUsers()
    {
        $userType = new UserType();
        
        $this->assertInstanceOf(Collection::class, $userType->users);
    }
}
