<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialiteFieldsToUsersTable extends Migration
{
      /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->string('email',128)->nullable()->change();
            $table->string('password')->nullable()->change();
			$table->string('provider');
            $table->string('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('provider');
			$table->dropColumn('provider_id');
			$table->string('email',128)->nullable(false)->change();
			$table->string('password')->nullable(false)->change();
		});
    }
}
