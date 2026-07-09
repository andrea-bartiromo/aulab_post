<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['name', 'slug'];

    /**
     * Configurazione per la generazione automatica dello slug
     * utilizzando il pacchetto eloquent-sluggable.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Relazione One-to-Many con Article: una categoria ha più articoli.
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
