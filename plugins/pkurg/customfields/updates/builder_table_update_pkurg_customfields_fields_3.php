<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePkurgCustomfieldsFields3 extends Migration
{
    public function up()
    {
        Schema::table('pkurg_customfields_fields', function($table)
        {
            $table->text('default')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('pkurg_customfields_fields', function($table)
        {
            $table->dropColumn('default');
        });
    }
}
