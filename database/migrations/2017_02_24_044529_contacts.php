<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class Contacts.
 *
 * @author  The scaffold-interface created at 2017-02-24 04:45:29pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Contacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('contacts',function (Blueprint $table){

        $table->increments('id');
        
        $table->String('name');
        
        $table->String('surname');
        
        $table->String('email');
        
        $table->String('phone');
        
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
        Schema::drop('contacts');
    }
}
