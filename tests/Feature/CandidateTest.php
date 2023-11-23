<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CandidateTest extends TestCase
{
    /**
     * Get all candidates test example.
     *
     * @return void
     */
    public function testGetAllCandidate()
    {
        // $this->json('POST', 'api/candidates')
        $this->get('api/candidates')
        ->assertStatus(200)
        ->assertJsonStructure([
            "status_code",
            "candidates" => []
        ]);
    }

    /**
     * Contact candidate test example.
     *
     * @return void
     */
    public function testContactCandidate()
    {
        $this->json('POST', 'api/candidates-contact/1')
        ->assertStatus(200)
        ->assertExactJson([
            "status_code" => 200,
            "message" => 'Contact email send successfully'
        ]);
    }

    /**
     * Hire candidate test example.
     *
     * @return void
     */
    public function testHireCandidate()
    {
        $this->testContactCandidate();

        $this->json('POST', 'api/candidates-hire/1')
        ->assertStatus(200)
        ->assertExactJson([
            "status_code" => 200,
            "message" => 'Hiring email send successfully'
        ]);
    }
}
