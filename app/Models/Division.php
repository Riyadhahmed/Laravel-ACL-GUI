<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
   //
   protected $guarded = ['id'];
   protected $fillable = [
     'division_name', 'division_area', 'division_address',
   ];
}
