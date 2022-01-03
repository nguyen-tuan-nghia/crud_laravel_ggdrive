<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    public $timestamps=false;
    protected $fillable=[
        'product_name','product_slug','product_key','product_meta','product_content','product_img','product_status','product_auth'];
    protected $primaryKey='product_id';
    protected $table='tbl_product';
}
