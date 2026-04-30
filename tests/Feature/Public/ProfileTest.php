<?php

namespace Tests\Feature\Public;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_requires_authentication(): void
    {
        $response = $this->get('/test/profile');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_profile(): void
    {
        $account = Account::factory()->create();

        $response = $this->actingAs($account)->get('/test/profile');
        $response->assertStatus(200);
    }

    public function test_user_can_update_profile(): void
    {
        $account = Account::factory()->create();

        $response = $this->actingAs($account)->patch('/test/profile/update', [
            'name'      => 'Nama Baru',
            'email'     => $account->email,
            'phone'     => '081234567890',
            'birthdate' => '1995-05-15',
            'weight'    => 65,
            'height'    => 170,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $account->refresh();
        $this->assertEquals('Nama Baru', $account->nama_lengkap);
        $this->assertEquals('081234567890', $account->phone);
    }

    public function test_user_can_upload_photo(): void
    {
        Storage::fake('public');
        $account = Account::factory()->create();

        $response = $this->actingAs($account)->patch('/test/profile/update', [
            'name'  => 'Test User',
            'email' => $account->email,
            'photo' => UploadedFile::fake()->image('avatar.jpg', 200, 200),
        ]);

        $response->assertRedirect();
        $account->refresh();
        $this->assertNotNull($account->photo);
        Storage::disk('public')->assertExists($account->photo);
    }

    public function test_profile_update_validation(): void
    {
        $account = Account::factory()->create();

        $response = $this->actingAs($account)->patch('/test/profile/update', [
            'name'  => '',
            'email' => 'invalid-email',
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }
}
