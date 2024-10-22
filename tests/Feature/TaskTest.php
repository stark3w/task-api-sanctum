<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function it_can_create_a_task_with_token_ability()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $token = $user->createToken('test-token', ['task:manage'])->plainTextToken;

        $taskData = Task::factory()->make()->toArray();

        $response = $this->postJson('/api/Tasks', $taskData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $taskData);
    }

}
