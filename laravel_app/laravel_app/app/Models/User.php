<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPushSubscriptions;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function medicalInstitutions()
    {
        return $this->hasMany(MedicalInstitution::class);
    }

    // 自分が作成したファミリーグループ
    public function ownedFamilyGroup()
    {
        return $this->hasOne(FamilyGroup::class, 'owner_id');
    }

    // 参加しているファミリーグループ
    public function familyGroups()
    {
        return $this->belongsToMany(FamilyGroup::class, 'family_group_members');
    }
}