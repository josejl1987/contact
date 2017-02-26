<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     * @table contacts_groups
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('contacts_groups');

        Schema::create('contacts_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->unsignedInteger('contact_id');
            $table->unsignedInteger('group_id');

            $table->unique(["contact_id", "group_id"], 'contact_id_group_id');


            $table->foreign('contact_id', 'contacts_groups_contact_id_indexFK')
                ->references('id')->on('contacts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('group_id', 'contacts_groups_group_id_indexFK')
                ->references('id')->on('groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists('contacts_groups');
     }
}
