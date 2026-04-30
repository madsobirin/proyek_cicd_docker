<?php

namespace Tests\Unit\Middleware;

use App\Http\Middleware\AdminMiddleware;
use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_middleware_redirects_unauthenticated_user(): void
    {
        $request = Request::create('/admin', 'GET');
        $middleware = new AdminMiddleware();

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_middleware_aborts_non_admin_user(): void
    {
        $user = Account::factory()->create(['role' => 'user']);
        Auth::login($user);

        $request = Request::create('/admin', 'GET');
        $middleware = new AdminMiddleware();

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $middleware->handle($request, function ($req) {
            return response('OK');
        });
    }

    public function test_middleware_allows_admin_user(): void
    {
        $admin = Account::factory()->admin()->create();
        Auth::login($admin);

        $request = Request::create('/admin', 'GET');
        $middleware = new AdminMiddleware();

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }
}
