<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('nick_name',50);
            $table->string('email',60)->unique();
            $table->smallInteger('phone');
            $table->string('address'); 
            $table->string('company',60);
            $table->dateTime('birth_date');
			$table->tinyInteger('gender');
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->index('id');
			
			$table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('contacts');
    }
}
