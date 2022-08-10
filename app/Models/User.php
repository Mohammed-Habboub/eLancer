<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Users Has One FreeLancer Profaile
    public function freelancer()
    {
        return $this->hasOne(Freelancer::class, 'user_id', 'id')
            ->withDefault();
    }

    public function projects()
    {
        return $this->hasMany(Project::class, 'user_id', 'id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'freelancer_id', 'id');
    }

    

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'freelancer_id', 'id');
    }

    public function proposedProjects()
    {
        return $this->belongsToMany(
            Project::class, 
            'proposals', 
            'freelancer_id',
            'project_id'
        )->withPivot([
            'description', 'cost', 'duration', 'duration_unit', 'status',
        ]);
    }

    public function contractedProjects()
    {
        return $this->belongsToMany(
            Project::class, 
            'contracts', 
            'freelancer_id',
            'project_id'
        )->withPivot([
            'proposal_id', 'cost',
            'type', 'start_on', 'end_on', 'completed_on', 'hours', 'status'
        ]);
    }

    
    // 1.Accessor Methods using to read
    // $user->profile_photo_url
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->freelancer->profile_photo_path) {
            return asset('storage/' . $this->freelancer->profile_photo_path);
        }
        return asset('images/default-photo.jpg');
    }

    // $this->name // The Attri (name) is exist therfore enter the method
    public function getNameAttribute($value)
    {
        return Str::title($value);
    }
    
    // 2.Mutators
    // $user->email = "KMafh9@gmail.com" -> ""kmafh9@gmail.com""
    // public function setEmailAttribute($value)
    // {
    //     $this->attribute['email'] = Str::lower($value);
    // }
}
