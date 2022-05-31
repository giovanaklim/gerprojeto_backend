<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Stage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->loginCustomer();
    }

    public function testShouldStoreProjectWithoutStages()
    {
        $this->loginCustomer();
        $project = Project::factory()->make();

        $this->post('api/project', $project->toArray())
            ->assertStatus(200);
    }

    public function testShouldStoreProjectWithStages()
    {
        $this->loginCustomer();
        $project = Project::factory()->make();
        $stages = Stage::factory()->count(3)->make([
            'project_id' => $project->id
        ]);

        $project['stages'] = $stages->toArray();

        $this->post('api/project', $project->toArray())
            ->assertStatus(200);
    }


    public function testShouldNotStoreProjectWithEmptyParams()
    {
        $this->loginCustomer();
        $this->post('api/project', [])
            ->assertStatus(302);
    }

    public function testShouldNotStoreProjectWithInvalidParams()
    {
        $this->loginCustomer();
        $project = Project::factory()->make([
            'status' => 'fail'
        ]);

        $this->post('api/project', $project->toArray())
            ->assertStatus(500);
    }
}
