<?php namespace mww\Movie\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMwwMovie extends Migration
{
    public function up()
    {
        Schema::create('mww_movie_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('movie_title', 255);
            $table->text('movie_year')->nullable();
            $table->string('movie_certificate');
            $table->text('movie_synopsis');
            $table->string('movie_slug');
            $table->string('movie_poster')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mww_movie_');
    }
}
