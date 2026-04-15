<?php

namespace Aranus\Chatbot\Tests\Feature;

use Aranus\Chatbot\Tests\BasicTestCase;
use Illuminate\Support\Facades\Route;

class RoutesTest extends BasicTestCase
{
    public function test_public_routes_are_registered(): void
    {
        $this->assertTrue(Route::has('chatbot.store'));
        $this->assertTrue(Route::has('chatbot.index'));
        $this->assertTrue(Route::has('chatbot.popular'));
    }

    public function test_dashboard_routes_are_registered(): void
    {
        $this->assertTrue(Route::has('chatbot.livechat'));
        $this->assertTrue(Route::has('chatbot.kb'));
        $this->assertTrue(Route::has('chatbot.kb.upload'));
        $this->assertTrue(Route::has('chatbot.kb.dataset'));
    }

    public function test_dashboard_live_chat_route_can_be_rendered_without_auth(): void
    {
        $response = $this->withoutMiddleware()->get('/dashboard/live-chat');

        $response->assertOk();
        $response->assertViewIs('chatbot::dashboard.live_chat');
    }

    // Note: routes that depend on database queries like /dashboard/knowledge-base
    // and /aranus-chatbot/popular-questions are not executed here so the test suite
    // can still run in environments without a preconfigured database.

    public function test_package_views_are_available(): void
    {
        $this->assertTrue(view()->exists('chatbot::widget'));
        $this->assertTrue(view()->exists('chatbot::dashboard.chatlog.index'));
        $this->assertTrue(view()->exists('chatbot::dashboard.knowledge-base.dataset'));
    }
}
