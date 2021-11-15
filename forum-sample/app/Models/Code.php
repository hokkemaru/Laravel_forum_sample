<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CodeKind;
use App\Models\ForumPost;


class Code extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'kind',
        'sort',
        'name',
    ];

    public function getExistingCode($kind, $sort) {
        $existing_code = Code::where('kind', $kind)
                            ->where('sort', $sort)
                            ->get();
        return $existing_code;
    }

    public function getCodes($code) {
        $target_kind = CodeKind::where('name', $code)->first();
        $codes = $target_kind->code()
                    ->orderBy('sort', 'asc')
                    ->get();
        return $codes;
    }

    public function forumPosts() {
        return $this->hasMany(ForumPost::class, 'category_id');
    }

    public function codeKind() {
        return $this->belongsTo(CodeKind::class, 'kind', 'kind');
    }
}
