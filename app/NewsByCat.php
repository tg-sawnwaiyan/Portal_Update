<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsByCat extends Model
{
    public $table = 'news_for_category';
    public $fillable = ['post_date','type','status','description'];
}
