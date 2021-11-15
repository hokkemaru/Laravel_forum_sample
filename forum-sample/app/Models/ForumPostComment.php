<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ForumPostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_post_id',
        'user_id',
        'parent_id',
        'comment',
    ];

    public function children() {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
