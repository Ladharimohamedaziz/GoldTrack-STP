<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */


    // public function getFilamentAvatarUrl(): ?string
    // {
    //     return $this->profile_image 
    //         ? asset('storage/' . $this->profile_image)
    //         : asset('default-avatar.png'); // optional
    // }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_image
            ? asset('storage/' . $this->profile_image)
            : asset('default-avatar.png'); // optional default
    }


    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'dob',
        'password',
        'profile_image',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // public function getFilamentName(): string
    // {
    //     return $this->name;
    // }

    //     public function getFilamentAvatarUrl(): ?string
    // {
    //     return $this->avatar_url; 
    // }

        public function canAccessPanel(\Filament\Panel $panel): bool
    {
        // 👇 customize access (example: only admins)
        return true; // or $this->is_admin === 1;
    }
}
