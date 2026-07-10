<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobApplicationCvDownloadTest extends TestCase
{
    use RefreshDatabase;

    private function createApplicationWithCv(): JobApplication
    {
        $user = User::factory()->create();

        Storage::disk('local')->put('cvs/sample.pdf', 'fake cv content');

        return JobApplication::create([
            'user_id' => $user->id,
            'message' => 'Messaggio di candidatura di prova.',
            'cv_path' => 'cvs/sample.pdf',
            'status' => 'pending',
        ]);
    }

    public function test_guest_cannot_download_cv(): void
    {
        $application = $this->createApplicationWithCv();

        $response = $this->get(route('jobApplications.cv.download', $application));

        $response->assertRedirect(route('login'));
    }

    public function test_unauthorized_user_cannot_download_cv(): void
    {
        $application = $this->createApplicationWithCv();
        $writer = User::factory()->create(['is_writer' => true]);

        $response = $this->actingAs($writer)->get(route('jobApplications.cv.download', $application));

        $response->assertForbidden();
    }

    public function test_admin_can_download_cv(): void
    {
        $application = $this->createApplicationWithCv();
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('jobApplications.cv.download', $application));

        $response->assertOk();
        $response->assertDownload('sample.pdf');
    }

    public function test_owner_can_download_cv(): void
    {
        $application = $this->createApplicationWithCv();
        $owner = User::factory()->create(['is_owner' => true]);

        $response = $this->actingAs($owner)->get(route('jobApplications.cv.download', $application));

        $response->assertOk();
        $response->assertDownload('sample.pdf');
    }

    public function test_download_returns_404_when_cv_file_is_missing(): void
    {
        $user = User::factory()->create();
        $application = JobApplication::create([
            'user_id' => $user->id,
            'message' => 'Messaggio di candidatura di prova.',
            'cv_path' => 'cvs/missing.pdf',
            'status' => 'pending',
        ]);
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('jobApplications.cv.download', $application));

        $response->assertNotFound();
    }

    public function test_cv_is_stored_on_local_disk_not_public(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)->post(route('job.submit'), [
            'message' => 'Messaggio di candidatura di prova valido.',
            'cv' => UploadedFile::fake()->create('curriculum.pdf', 100, 'application/pdf'),
        ]);

        $application = JobApplication::first();

        $this->assertNotNull($application);
        Storage::disk('local')->assertExists($application->cv_path);
        Storage::disk('public')->assertMissing($application->cv_path);
    }
}
