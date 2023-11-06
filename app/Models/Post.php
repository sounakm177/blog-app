<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    Protected $fillable = ['title','text','image','created_by'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset('storage/'.$value),
            set: fn (string $value) => $value,
        );
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id')->orderBy('id','DESC');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
