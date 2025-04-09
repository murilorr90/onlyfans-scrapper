<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Profile extends Model
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'username' => $this->username,
            'name'     => $this->name,
            'bio'      => $this->bio,
        ];
    }

    protected $fillable = [
        'name',
        'username',
        'bio',
        'likes'
    ];
}
