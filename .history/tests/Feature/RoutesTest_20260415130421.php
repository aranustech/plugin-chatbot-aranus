<?php

namespace Aranus\Chatbot\Tests\Feature;

use Aranus\Chatbot\Tests\TestCase;
use Illuminate\Support\Facades\Route;

class RoutesTest extends TestCase
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

    public function test_popular_questions_endpoint_returns_json_array(): void
    {
        $response = $this->getJson('/aranus-chatbot/popular-questions');

        $response->assertOk();
        $response->assertJsonIsArray();
    }

    public function test_dashboard_live_chat_route_can_be_rendered_without_auth(): void
    {
        $response = $this->withoutMiddleware()->get('/dashboard/live-chat');

        $response->assertOk();
        $response->assertViewIs('chatbot::dashboard.live_chat');
    }

    public function test_dashboard_knowledge_base_route_can_be_rendered_without_auth(): void
    {
        $response = $this->withoutMiddleware()->get('/dashboard/knowledge-base');

        $response->assertOk();
        $response->assertViewIs('chatbot::dashboard.knowledge-base.index');
    }

    public function test_package_views_are_available(): void
    {
        $this->assertTrue(view()->exists('chatbot::widget'));
        $this->assertTrue(view()->exists('chatbot::dashboard.chatlog.index'));
        $this->assertTrue(view()->exists('chatbot::dashboard.knowledge-base.dataset'));
    }
}
