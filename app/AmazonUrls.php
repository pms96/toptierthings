<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmazonUrls extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'product_code', 'post_id', 'post',
    ];
}
