<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePkurgCustomfieldsValueData extends Migration
{
    public function up()
    {
        Schema::table('pkurg_customfields_value_data', function($table)
        {
            $table->string('name')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('pkurg_customfields_value_data', function($table)
        {
            $table->dropColumn('name');
        });
    }
}
