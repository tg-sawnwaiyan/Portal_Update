<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
        protected $table = 'categories';
        public $fillable = ['name','user_id','recordstatus','order_number'];

}
