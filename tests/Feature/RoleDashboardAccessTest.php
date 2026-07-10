<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleDashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'is_admin' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_revisor_can_access_revisor_dashboard(): void
    {
        $revisor = User::factory()->create([
            'is_revisor' => true,
        ]);

        $response = $this->actingAs($revisor)->get(route('revisor.dashboard'));

        $response->assertOk();
    }

    public function test_writer_can_access_writer_article_edit(): void
    {
        $writer = User::factory()->create([
            'is_writer' => true,
        ]);

        $category = Category::create([
            'name' => 'Tecnologia',
        ]);

        $article = Article::create([
            'title' => 'Articolo di prova',
            'subtitle' => 'Sottotitolo di prova',
            'body' => 'Contenuto di prova',
            'category_id' => $category->id,
            'user_id' => $writer->id,
        ]);

        $response = $this->actingAs($writer)->get(route('articles.edit', $article));

        $response->assertOk();
    }

    public function test_owner_can_access_owner_dashboard(): void
    {
        $owner = User::factory()->create([
            'is_owner' => true,
        ]);

        $response = $this->actingAs($owner)->get(route('owner.dashboard'));

        $response->assertOk();
    }

    public function test_user_without_privileges_cannot_access_protected_dashboards(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertRedirect(route('home'));
        $this->actingAs($user)->get(route('revisor.dashboard'))->assertRedirect(route('home'));
        $this->actingAs($user)->get(route('owner.dashboard'))->assertRedirect(route('home'));
    }

    public function test_user_without_writer_role_cannot_access_writer_article_edit(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Tecnologia',
        ]);

        $article = Article::create([
            'title' => 'Articolo di prova',
            'subtitle' => 'Sottotitolo di prova',
            'body' => 'Contenuto di prova',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('articles.edit', $article));

        $response->assertRedirect(route('home'));
    }
}
