<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->string('email')->nullable();
            $table->enum('called' ,['no' ,'yes','no_answer'])->default('no'); 
            $table->enum('status' ,['processing','accepted' ,'rejected'])->default('processing'); 
            $table->string('cv')->nullable();         
            $table->datetime('start_time');        
            $table->longText('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
