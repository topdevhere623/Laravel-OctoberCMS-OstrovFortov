<?php namespace Pkurg\Customfields\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdatePkurgCustomfieldsValueData3 extends Migration
{
    public function up()
    {
        Schema::table('pkurg_customfields_value_data', function($table)
        {
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
        Schema::table('pkurg_customfields_value_data', function($table)
        {
            $table->dropColumn('value17');
            $table->dropColumn('value18');
            $table->dropColumn('value19');
            $table->dropColumn('value20');
            $table->dropColumn('value21');
            $table->dropColumn('value22');
            $table->dropColumn('value23');
            $table->dropColumn('value24');
            $table->dropColumn('value25');
            $table->dropColumn('value26');
            $table->dropColumn('value27');
            $table->dropColumn('value28');
            $table->dropColumn('value29');
            $table->dropColumn('value30');
            $table->dropColumn('value31');
            $table->dropColumn('value32');
        });
    }
}
