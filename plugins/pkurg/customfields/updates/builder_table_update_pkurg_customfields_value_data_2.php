<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePkurgCustomfieldsValueData2 extends Migration
{
    public function up()
    {
        Schema::table('pkurg_customfields_value_data', function($table)
        {
            $table->integer('customfields_id')->nullable();
            $table->dropColumn('name');
        });
    }
    
    public function down()
    {
        Schema::table('pkurg_customfields_value_data', function($table)
        {
            $table->dropColumn('customfields_id');
            $table->string('name', 191)->nullable();
        });
    }
}
