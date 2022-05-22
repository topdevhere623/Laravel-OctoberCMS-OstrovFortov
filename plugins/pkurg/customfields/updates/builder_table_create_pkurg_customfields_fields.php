<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePkurgCustomfieldsFields extends Migration
{
    public function up()
    {
        Schema::create('pkurg_customfields_fields', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('type')->nullable();
            $table->text('name')->nullable();
            $table->text('custom_fields')->nullable();
            $table->text('caption')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pkurg_customfields_fields');
    }
}
