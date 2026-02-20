<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];
    protected $hidden = ['password', 'remember_token'];

    // Relasi jika user adalah Dosen
    public function lecturerProfile()
    {
        return $this->hasOne(Lecturer::class);
    }

    // Relasi konsultasi (sebagai klien)
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'user_id');
    }
}
