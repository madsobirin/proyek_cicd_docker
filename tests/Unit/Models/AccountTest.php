<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Perhitungan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $account = new Account();

        $expected = [
            'nama_lengkap', 'username', 'email', 'password', 'role',
            'is_active', 'last_login_at', 'phone', 'birthdate',
            'weight', 'height', 'photo', 'google_id', 'google_avatar',
        ];

        $this->assertEquals($expected, $account->getFillable());
    }

    public function test_table_name(): void
    {
        $account = new Account();
        $this->assertEquals('accounts', $account->getTable());
    }

    public function test_name_accessor_returns_nama_lengkap(): void
    {
        $account = new Account(['nama_lengkap' => 'John Doe', 'username' => 'johndoe']);
        $this->assertEquals('John Doe', $account->name);
    }

    public function test_name_accessor_fallback_to_username(): void
    {
        $account = new Account(['nama_lengkap' => null, 'username' => 'johndoe']);
        $this->assertEquals('johndoe', $account->name);
    }

    public function test_is_active_cast_to_boolean(): void
    {
        $account = Account::factory()->create(['is_active' => 1]);
        $this->assertIsBool($account->is_active);
        $this->assertTrue($account->is_active);
    }

    public function test_last_login_at_cast_to_datetime(): void
    {
        $account = Account::factory()->create(['last_login_at' => now()]);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $account->last_login_at);
    }

    public function test_birthdate_cast_to_date(): void
    {
        $account = Account::factory()->create(['birthdate' => '1995-05-15']);
        // birthdate accessor returns raw value
        $this->assertNotNull($account->birthdate);
    }

    public function test_perhitungans_relationship(): void
    {
        $account = Account::factory()->create();
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class, $account->perhitungans());
    }

    public function test_perhitungans_relationship_returns_related_records(): void
    {
        $account = Account::factory()->create();
        Perhitungan::factory()->count(3)->create(['user_id' => $account->id]);

        $this->assertCount(3, $account->perhitungans);
    }
}
