<?php namespace mww\Movie\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMwwMovieGenre extends Migration
{
    public function up()
    {
        Schema::create('mww_movie_genre', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('genre_title');
            $table->string('genre_slug');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mww_movie_genre');
    }
}
