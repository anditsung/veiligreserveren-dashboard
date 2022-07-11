<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketdata extends Model
{
    use HasFactory;

    protected $primaryKey = 't_id';
    protected $table = 'ticketdata';

    /**
    * Get the comments for the blog post.
    */
    public function entrees()
    {
        return $this->hasOne(Entree::class, 'entree_id', 't_entreeid');
    }
    
}
