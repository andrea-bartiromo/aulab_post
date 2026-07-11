<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_writer_can_create_a_valid_article_that_is_unapproved_and_hidden_from_homepage(): void
    {
        $writer = User::factory()->create([
            'is_writer' => true,
        ]);

        $category = Category::create([
            'name' => 'Tecnologia',
        ]);

        $response = $this->actingAs($writer)->post(route('articles.store'), [
            'title' => 'Articolo non approvato',
            'subtitle' => 'Sottotitolo articolo',
            'body' => 'Contenuto articolo',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', [
            'title' => 'Articolo non approvato',
            'subtitle' => 'Sottotitolo articolo',
            'body' => 'Contenuto articolo',
            'category_id' => $category->id,
            'user_id' => $writer->id,
            'is_accepted' => null,
        ]);

        $article = Article::where('title', 'Articolo non approvato')->firstOrFail();

        $this->assertNull($article->is_accepted);
        $this->get(route('home'))->assertDontSee('Articolo non approvato');
    }

    public function test_revisor_can_approve_an_article_and_the_article_appears_on_homepage(): void
    {
        $revisor = User::factory()->create([
            'is_revisor' => true,
        ]);

        $article = $this->createArticle([
            'title' => 'Articolo approvabile',
            'is_accepted' => null,
        ]);

        $response = $this->actingAs($revisor)->post(route('revisor.acceptArticle', $article->id));

        $response->assertRedirect(route('revisor.dashboard'));

        $article->refresh();

        $this->assertTrue($article->is_accepted);
        $this->get(route('home'))->assertSee('Articolo approvabile');
    }

    public function test_revisor_can_view_a_pending_article(): void
    {
        $revisor = User::factory()->create([
            'is_revisor' => true,
        ]);

        $article = $this->createArticle([
            'title' => 'Articolo pending da revisionare',
            'is_accepted' => null,
        ]);

        $response = $this->actingAs($revisor)->get(route('articles.show', $article));

        $response->assertOk();
        $response->assertSee('Articolo pending da revisionare');
    }

    public function test_pending_article_is_forbidden_for_guests_and_non_revisors(): void
    {
        $article = $this->createArticle([
            'title' => 'Articolo pending riservato',
            'is_accepted' => null,
        ]);

        $this->get(route('articles.show', $article))->assertForbidden();

        $user = User::factory()->create();

        $this->actingAs($user)->get(route('articles.show', $article))->assertForbidden();
    }

    public function test_approved_article_remains_publicly_visible(): void
    {
        $article = $this->createArticle([
            'title' => 'Articolo approvato pubblico',
            'is_accepted' => true,
        ]);

        $response = $this->get(route('articles.show', $article));

        $response->assertOk();
        $response->assertSee('Articolo approvato pubblico');
    }

    public function test_author_can_update_own_article(): void
    {
        $author = User::factory()->create([
            'is_writer' => true,
        ]);

        $category = Category::create([
            'name' => 'Tecnologia',
        ]);

        $article = $this->createArticle([
            'title' => 'Titolo originale',
            'category_id' => $category->id,
            'user_id' => $author->id,
        ]);

        $response = $this->actingAs($author)->put(route('articles.update', $article), [
            'title' => 'Titolo aggiornato',
            'subtitle' => 'Sottotitolo aggiornato',
            'body' => 'Contenuto aggiornato',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Titolo aggiornato',
            'subtitle' => 'Sottotitolo aggiornato',
            'body' => 'Contenuto aggiornato',
            'category_id' => $category->id,
        ]);
    }

    public function test_different_writer_cannot_update_another_authors_article(): void
    {
        $author = User::factory()->create([
            'is_writer' => true,
        ]);

        $otherWriter = User::factory()->create([
            'is_writer' => true,
        ]);

        $category = Category::create([
            'name' => 'Tecnologia',
        ]);

        $article = $this->createArticle([
            'title' => 'Titolo autore',
            'subtitle' => 'Sottotitolo autore',
            'body' => 'Contenuto autore',
            'category_id' => $category->id,
            'user_id' => $author->id,
        ]);

        $response = $this->actingAs($otherWriter)->put(route('articles.update', $article), [
            'title' => 'Tentativo modifica',
            'subtitle' => 'Tentativo sottotitolo',
            'body' => 'Tentativo contenuto',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
            'title' => 'Titolo autore',
            'subtitle' => 'Sottotitolo autore',
            'body' => 'Contenuto autore',
        ]);
    }

    public function test_different_writer_cannot_edit_another_authors_article(): void
    {
        $author = User::factory()->create([
            'is_writer' => true,
        ]);

        $otherWriter = User::factory()->create([
            'is_writer' => true,
        ]);

        $article = $this->createArticle([
            'user_id' => $author->id,
        ]);

        $response = $this->actingAs($otherWriter)->get(route('articles.edit', $article));

        $response->assertRedirect(route('articles.index'));
    }

    public function test_author_can_delete_own_article_and_it_no_longer_exists(): void
    {
        $author = User::factory()->create([
            'is_writer' => true,
        ]);

        $article = $this->createArticle([
            'user_id' => $author->id,
        ]);

        $response = $this->actingAs($author)->delete(route('articles.destroy', $article));

        $response->assertRedirect(route('articles.index'));

        $this->assertDatabaseMissing('articles', [
            'id' => $article->id,
        ]);
    }

    public function test_different_writer_cannot_delete_another_authors_article(): void
    {
        $author = User::factory()->create([
            'is_writer' => true,
        ]);

        $otherWriter = User::factory()->create([
            'is_writer' => true,
        ]);

        $article = $this->createArticle([
            'user_id' => $author->id,
        ]);

        $response = $this->actingAs($otherWriter)->delete(route('articles.destroy', $article));

        $response->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
        ]);
    }

    private function createArticle(array $attributes = []): Article
    {
        $category = $attributes['category_id'] ?? Category::create([
            'name' => 'Tecnologia',
        ])->id;

        $user = $attributes['user_id'] ?? User::factory()->create([
            'is_writer' => true,
        ])->id;

        return Article::create(array_merge([
            'title' => 'Articolo di prova',
            'subtitle' => 'Sottotitolo di prova',
            'body' => 'Contenuto di prova',
            'category_id' => $category,
            'user_id' => $user,
            'is_accepted' => null,
        ], $attributes));
    }
}
