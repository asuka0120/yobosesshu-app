<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FamilyGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'invite_code',
    ];

    // オーナー
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // メンバー
    public function members()
    {
        return $this->belongsToMany(User::class, 'family_group_members');
    }

    // 招待コード自動生成
    public static function generateInviteCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('invite_code', $code)->exists());

        return $code;
    }
}