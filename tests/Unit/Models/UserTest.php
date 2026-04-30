<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $user = new User();

        $expected = [
            'username', 'email', 'password', 'role', 'is_active', 'last_login_at',
        ];

        $this->assertEquals($expected, $user->getFillable());
    }

    public function test_hidden_attributes(): void
    {
        $user = new User();
        $this->assertContains('password', $user->getHidden());
        $this->assertContains('remember_token', $user->getHidden());
    }

    public function test_uses_has_factory_trait(): void
    {
        $this->assertContains(
            \Illuminate\Database\Eloquent\Factories\HasFactory::class,
            class_uses_recursive(User::class)
        );
    }

    public function test_casts_include_password_hashed(): void
    {
        $user = new User();
        $casts = $user->getCasts();
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('hashed', $casts['password']);
    }
}
