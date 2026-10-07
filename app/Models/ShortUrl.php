<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ShortUrl extends Model
{
    use HasFactory;

    // Codes that must never be generated, so they can't clash with app routes
    private const RESERVED = ['logout', 'invite', 'login'];

    protected $fillable = ['company_id', 'user_id', 'original_url', 'short_code'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateUniqueCode(int $length = 6): string
    {
        do {
            $code = Str::random($length);
        } while (
            in_array(strtolower($code), self::RESERVED, true)
            || self::where('short_code', $code)->exists()
        );

        return $code;
    }
}