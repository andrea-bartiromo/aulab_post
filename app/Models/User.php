<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Article;
use App\Models\JobApplication;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_revisor',
        'is_writer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_revisor' => 'boolean',
            'is_writer' => 'boolean',
        ];
    }

    /**
     * Relazione: un utente può avere più articoli.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Relazione: un utente può inviare più candidature.
     */
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Verifica se l'utente è un admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Verifica se l'utente è un revisore.
     */
    public function isRevisor(): bool
    {
        return $this->is_revisor;
    }

    /**
     * Verifica se l'utente è un writer.
     */
    public function isWriter(): bool
    {
        return $this->is_writer;
    }
}
