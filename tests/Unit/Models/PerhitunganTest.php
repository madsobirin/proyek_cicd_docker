<?php

namespace Tests\Unit\Models;

use App\Models\Account;
use App\Models\Perhitungan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PerhitunganTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $perhitungan = new Perhitungan();

        $expected = [
            'user_id', 'tinggi_badan', 'berat_badan', 'bmi', 'status',
        ];

        $this->assertEquals($expected, $perhitungan->getFillable());
    }

    public function test_table_name(): void
    {
        $perhitungan = new Perhitungan();
        $this->assertEquals('perhitungan', $perhitungan->getTable());
    }

    public function test_uses_has_factory_trait(): void
    {
        $this->assertContains(
            \Illuminate\Database\Eloquent\Factories\HasFactory::class,
            class_uses_recursive(Perhitungan::class)
        );
    }

    public function test_account_relationship(): void
    {
        $perhitungan = new Perhitungan();
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $perhitungan->account()
        );
    }

    public function test_account_relationship_returns_correct_account(): void
    {
        $account = Account::factory()->create();
        $perhitungan = Perhitungan::factory()->create(['user_id' => $account->id]);

        $this->assertEquals($account->id, $perhitungan->account->id);
    }
}
