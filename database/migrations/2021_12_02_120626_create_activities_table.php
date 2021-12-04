<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->integer('auth_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->tinyInteger('activity_status')->nullable()->comment('1=create_post, 2=update_post, 3=delete_post, 4=add_friend, 5=cancel_add, 6=accept_request, 7=dont_accept_request, 8=unfriend, 9=like, 10=unlike, 11=stalk, 12=tag');
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
        Schema::dropIfExists('activities');
    }
}
