<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entree extends Model
{
    use HasFactory;

    protected $primaryKey = 'entree_id';

    // /**
    //  * Get the comments for the blog post.
    //  */
    // public function events()
    // {
    //     return $this->hasOne(Event::class, 'event_id', 'entree_eventid');
    // }

    /**
     * Get the comments for the blog post.
     */
    // public function event()
    // {
    //     return $this->belongsTo(Event::class, 'event_id', 'entree_eventid');
    // }

    public function event()
    {
        return $this->belongsTo(Event::class, 'entree_eventid', 'event_id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function ticketdatas()
    {
        return $this->HasMany(Ticketdata::class, 't_entreeid', 'entree_id');
    }

    protected $casts = [
        'entree_salestart' => 'date',
        'entree_saleend' => 'date',
    ];
}
