<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MModel extends Model
{
    protected $table = 'models';
    protected $fillable = [
        'name','color','year','note','image_url_1','image_url_2','count','registration_number','manufacturer_id',
    ];
}
