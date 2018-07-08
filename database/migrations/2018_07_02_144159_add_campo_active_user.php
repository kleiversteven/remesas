<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCampoActiveUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users',function($table){
            
            $table->boolean('confirmed')->default(0);
            $table->boolean('estatus')->default(0);
            $table->string('confirmation_codemed')->nullable(0);
            $table->string('avatar')->default('avatars/default.png');
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users',function($table){
            
            $table->dropColumn('confirmed');
            $table->dropColumn('estatus');
            $table->dropColumn('confirmation_codemed');
            $table->dropColumn('avatar');
            
        });
    }
    
}
