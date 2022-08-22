<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';

    /**
     * Get the comments for the blog post.
     */
    public function entrees()
    {
        return $this->hasMany(Entree::class, 'entree_orgid', 'event_orgid');
    }
}
