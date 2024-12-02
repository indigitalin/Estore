<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_full_name_accessor(): void
    {
        $user = new User(['firstname' => 'John', 'lastname' => 'Doe']);
        $this->assertEquals('John Doe', $user->name);
    }
}
