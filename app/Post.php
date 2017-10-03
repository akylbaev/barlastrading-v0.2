<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    // Specifying table name and attributes
    // Table Name
    protected $table = 'posts';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;

    // Model Relationships on Post
    public function user() {
        return $this->belongsTo('App\User');
    }


}
