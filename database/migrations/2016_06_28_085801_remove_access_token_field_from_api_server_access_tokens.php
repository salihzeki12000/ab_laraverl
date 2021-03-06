<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAccessTokenFieldFromApiServerAccessTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('api_server_access_tokens', function(Blueprint $table)
        {
            $table->dropColumn('access_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('api_server_access_tokens', function(Blueprint $table)
        {
            $table->string('access_token');
        });
    }
}
