<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto_profil',
        'last_login',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    // Tambahkan accessor untuk foto profil
    public function getFotoProfilUrlAttribute()
    {
        if ($this->foto_profil) {
            // Cek apakah file ada di storage public
            if (Storage::disk('public')->exists($this->foto_profil)) {
                return asset('storage/' . $this->foto_profil);
            }

            // Kompatibilitas dengan format lama
            if (Storage::disk('public')->exists('foto-profil/' . $this->foto_profil)) {
                return asset('storage/foto-profil/' . $this->foto_profil);
            }

            // Cek di path publik langsung
            if (file_exists(public_path('storage/' . $this->foto_profil))) {
                return asset('storage/' . $this->foto_profil);
            }
        }

        // Default avatar jika tidak ada foto
        return asset('asset-admin/img/user.jpg');
    }

    // Cek apakah user memiliki foto profil
    public function hasFotoProfil()
    {
        if (!$this->foto_profil) {
            return false;
        }

        // Cek berbagai kemungkinan lokasi file
        if (Storage::disk('public')->exists($this->foto_profil)) {
            return true;
        }

        if (Storage::disk('public')->exists('foto-profil/' . $this->foto_profil)) {
            return true;
        }

        if (file_exists(public_path('storage/' . $this->foto_profil))) {
            return true;
        }

        return false;
    }

    // Get user role display
    public function getRoleDisplayAttribute()
    {
        return $this->role ?? 'Administrator';
    }

    /**
     * Check if email is verified
     */
    public function hasVerifiedEmail()
    {
        return !is_null($this->email_verified_at);
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified()
    {
        $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Get email for verification
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }

    /**
     * Send email verification notification
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new \Illuminate\Auth\Notifications\VerifyEmail);
    }
}
