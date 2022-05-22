<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePkurgCustomfieldsFields2 extends Migration
{
    public function up()
    {
        Schema::table('pkurg_customfields_fields', function($table)
        {
            $table->integer('maxitems')->unsigned()->default(100);
        });
    }
    
    public function down()
    {
        Schema::table('pkurg_customfields_fields', function($table)
        {
            $table->dropColumn('maxitems');
        });
    }
}
