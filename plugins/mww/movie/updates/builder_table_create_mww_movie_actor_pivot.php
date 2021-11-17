<?php namespace mww\Movie\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMwwMovieActorPivot extends Migration
{
    public function up()
    {
        Schema::create('mww_movie_actor_pivot', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('movie_id')->unsigned();
            $table->integer('actor_id')->unsigned();
            $table->primary(['movie_id','actor_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mww_movie_actor_pivot');
    }
}
