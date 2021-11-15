<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPostReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_post_id',
        'reaction_id',
        'user_id',
    ];
}
