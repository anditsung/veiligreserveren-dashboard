<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Organisation extends Model
{
    use HasFactory;

    protected $primaryKey = 'org_id';

    /**
     * Get the user's org_paymethodes.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

    protected function orgPaymethodes(): Attribute
    {
        $rand = rand(0, 200);

        return Attribute::make(
            set: fn ($value) => strtoupper($value . $rand),
        );
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'u_username'
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

    /**
     * Get the comments for the blog post.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'u_orgid', 'org_orgid');
    }

    /**
     * Get the comments for the blog post.
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'event_orgid', 'org_orgid');
    }
}
