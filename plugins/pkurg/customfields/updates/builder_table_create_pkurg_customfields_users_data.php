<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreatePkurgCustomfieldsUsersData extends Migration
{
    public function up()
    {
        Schema::create('pkurg_customfields_users_data', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('user_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('value')->nullable();
            $table->integer('customfields_id')->nullable();
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
            $table->text('value17')->nullable();
            $table->text('value18')->nullable();
            $table->text('value19')->nullable();
            $table->text('value20')->nullable();
            $table->text('value21')->nullable();
            $table->text('value22')->nullable();
            $table->text('value23')->nullable();
            $table->text('value24')->nullable();
            $table->text('value25')->nullable();
            $table->text('value26')->nullable();
            $table->text('value27')->nullable();
            $table->text('value28')->nullable();
            $table->text('value29')->nullable();
            $table->text('value30')->nullable();
            $table->text('value31')->nullable();
            $table->text('value32')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('pkurg_customfields_users_data');
    }
}
