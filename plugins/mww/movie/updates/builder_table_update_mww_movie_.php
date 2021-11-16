<?php namespace mww\Movie\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMwwMovie extends Migration
{
    public function up()
    {
        Schema::table('mww_movie_', function($table)
        {
            $table->text('movie_actors')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('mww_movie_', function($table)
        {
            $table->dropColumn('movie_actors');
        });
    }
}
