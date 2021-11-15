<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Code;

class CodeKind extends Model
{
    use HasFactory;

    protected $primaryKey = 'kind';

    public function code() {
        return $this->hasMany(Code::class, 'kind', 'kind');
    }
}
