<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    public $timestamps=false;
    protected $fillable=[
        'category_name','category_key','category_slug','category_status','category_meta'];
    protected $primaryKey='category_id';
    protected $table='tbl_category';
}
