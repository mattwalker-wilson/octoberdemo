<?php namespace mww\Movie\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMwwMovieGenrePivot extends Migration
{
    public function up()
    {
        Schema::create('mww_movie_genre_pivot', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('movie_id');
            $table->integer('genre_id');
            $table->primary(['movie_id','genre_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mww_movie_genre_pivot');
    }
}
