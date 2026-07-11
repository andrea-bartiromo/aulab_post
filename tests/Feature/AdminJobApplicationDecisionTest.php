<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminJobApplicationDecisionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_accept_a_pending_job_application(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $candidate = User::factory()->create(['is_revisor' => false]);
        $application = $this->createJobApplication($candidate, 'pending');

        $response = $this->actingAs($admin)->post(route('admin.acceptApplication', $application->id));

        $response->assertRedirect(route('admin.jobApplications'));

        $application->refresh();
        $candidate->refresh();

        $this->assertSame('accepted', $application->status);
        $this->assertTrue($candidate->is_revisor);
    }

    public function test_admin_can_reject_a_pending_job_application(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $candidate = User::factory()->create(['is_revisor' => false]);
        $application = $this->createJobApplication($candidate, 'pending');

        $response = $this->actingAs($admin)->post(route('admin.rejectApplication', $application->id));

        $response->assertRedirect(route('admin.jobApplications'));

        $application->refresh();
        $candidate->refresh();

        $this->assertSame('rejected', $application->status);
        $this->assertFalse($candidate->is_revisor);
    }

    public function test_admin_cannot_reject_an_accepted_job_application(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $candidate = User::factory()->create(['is_revisor' => true]);
        $application = $this->createJobApplication($candidate, 'accepted');

        $response = $this->actingAs($admin)->post(route('admin.rejectApplication', $application->id));

        $response->assertRedirect(route('admin.jobApplications'));

        $application->refresh();
        $candidate->refresh();

        $this->assertSame('accepted', $application->status);
        $this->assertTrue($candidate->is_revisor);
    }

    public function test_admin_cannot_accept_a_rejected_job_application(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $candidate = User::factory()->create(['is_revisor' => false]);
        $application = $this->createJobApplication($candidate, 'rejected');

        $response = $this->actingAs($admin)->post(route('admin.acceptApplication', $application->id));

        $response->assertRedirect(route('admin.jobApplications'));

        $application->refresh();
        $candidate->refresh();

        $this->assertSame('rejected', $application->status);
        $this->assertFalse($candidate->is_revisor);
    }

    private function createJobApplication(User $candidate, string $status): JobApplication
    {
        return JobApplication::create([
            'user_id' => $candidate->id,
            'message' => 'Messaggio di candidatura valido.',
            'cv_path' => 'cvs/sample.pdf',
            'status' => $status,
        ]);
    }
}
