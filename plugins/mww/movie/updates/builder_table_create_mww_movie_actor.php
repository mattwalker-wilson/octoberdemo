<?php namespace mww\Movie\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMwwMovieActor extends Migration
{
    public function up()
    {
        Schema::create('mww_movie_actor', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('actor_first_name');
            $table->string('actor_last_name');
            $table->date('actor_dob');
            $table->string('actor_birth_place');    
            $table->string('actor_slug');           
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mww_movie_actor');
    }
}
