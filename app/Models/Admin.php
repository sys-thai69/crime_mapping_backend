<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Admin extends Authenticatable implements AuthenticatableContract
{
    use HasFactory;

    protected $table = 'admin'; 
    protected $fillable = ['admin_username', 'admin_email', 'admin_pass','admin_id'];

    protected $hidden = [
        'admin_pass',
        'remember_token',
    ];

    // If your password column is named differently, override the getAuthPassword method
    public function getAuthPassword()
    {
        return $this->admin_pass;
    }

    public static function boot()
    {
        parent::boot();

        // Generate a unique 4-digit admin_id before creating a new Admin record
        static::creating(function ($admin) {
            $admin->admin_id = self::generateUniqueAdminId();
        });
    }

    private static function generateUniqueAdminId()
    {
        do {
            $adminId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('admin_id', $adminId)->exists());

        return $adminId;
    }
    
    public function adminCrime()
    {
        return $this->hasMany(Crime::class, 'approvedby_admin_id');
    }
}
