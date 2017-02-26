<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class Groups.
 *
 * @author  The scaffold-interface created at 2017-02-24 04:51:53pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Groups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('groups',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('name');
        
        /**
         * Foreignkeys section
         */
        
        
        
        // type your addition here

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::drop('groups');
    }
}
