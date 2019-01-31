<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionsTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('divisions', function (Blueprint $table) {
         $table->increments('id');
         $table->string('division_name');
         $table->string('division_area');
         $table->string('division_address');
         $table->tinyInteger('status')->default(1);
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('divisions');
   }
}
