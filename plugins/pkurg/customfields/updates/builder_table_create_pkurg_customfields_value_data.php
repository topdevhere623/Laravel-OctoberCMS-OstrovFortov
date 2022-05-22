<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePkurgCustomfieldsValueData extends Migration
{
    public function up()
    {
        Schema::create('pkurg_customfields_value_data', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('value')->nullable();
            $table->text('value1')->nullable();
            $table->text('value2')->nullable();
            $table->text('value3')->nullable();
            $table->text('value4')->nullable();
            $table->text('value5')->nullable();
            $table->text('value6')->nullable();
            $table->text('value7')->nullable();
            $table->text('value8')->nullable();
            $table->text('value9')->nullable();
            $table->text('value10')->nullable();
            $table->text('value11')->nullable();
            $table->text('value12')->nullable();
            $table->text('value13')->nullable();
            $table->text('value14')->nullable();
            $table->text('value15')->nullable();
            $table->text('value16')->nullable();
            $table->integer('post_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pkurg_customfields_value_data');
    }
}