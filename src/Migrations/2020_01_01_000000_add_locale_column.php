<?php

use Illuminate\Database\Migrations\Migration;

class AddLocaleColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->string('locale')->default(config('app.locale'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->dropColumn('locale');
        });
    }
}
