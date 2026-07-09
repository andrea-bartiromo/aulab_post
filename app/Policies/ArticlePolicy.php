<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{
    /**
     * Determina se l'utente può aggiornare l'articolo.
     */
    public function update(User $user, Article $article)
    {
        return $user->id === $article->user_id; // Solo il writer può modificare il proprio articolo
    }

    /**
     * Determina se l'utente può eliminare l'articolo.
     */
    public function delete(User $user, Article $article)
    {
        return $user->id === $article->user_id; // Solo il writer può eliminare il proprio articolo
    }
}
