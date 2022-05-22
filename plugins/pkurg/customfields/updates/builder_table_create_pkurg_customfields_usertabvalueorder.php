<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePkurgCustomfieldsUsertabvalueorder extends Migration
{
    public function up()
    {
        Schema::create('pkurg_customfields_usertabvalueorder', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('tabname')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pkurg_customfields_usertabvalueorder');
    }
}
