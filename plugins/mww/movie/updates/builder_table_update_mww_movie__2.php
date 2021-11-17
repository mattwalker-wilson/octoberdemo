<?php namespace mww\Movie\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMwwMovie2 extends Migration
{
    public function up()
    {
        Schema::table('mww_movie_', function($table)
        {
            $table->dropColumn('movie_actors');
        });
    }
    
    public function down()
    {
        Schema::table('mww_movie_', function($table)
        {
            $table->text('movie_actors')->nullable();
        });
    }
}
