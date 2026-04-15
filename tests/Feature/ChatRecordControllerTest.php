<?php

namespace Aranus\Chatbot\Tests\Feature;

use Aranus\Chatbot\Tests\TestCase;

class ChatRecordControllerTest extends TestCase
{
    public function test_store_chat_record_creates_database_entry(): void
    {
        $response = $this->postJson('/aranus-chatbot/store-chat', [
            'client_message' => 'Halo AI',
            'ai_message' => 'Halo kembali',
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('chat_records', [
            'client_message' => 'Halo AI',
            'ai_message' => 'Halo kembali',
        ]);
    }
}
