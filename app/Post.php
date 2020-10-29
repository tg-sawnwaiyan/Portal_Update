<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title','photo','main_point','body','category_id', 'related_news' ,'user_id','recordstatus','from_date','to_date','created_by','created_by_company'
    ];
}
