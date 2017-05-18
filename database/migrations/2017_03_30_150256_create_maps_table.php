    <?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('maps', function (Blueprint $table) {
           
            $table->increments('id');
                $table->integer('user_id');
                $table->longText('map');
                $table->string('state');
                $table->string('screenshot');
                $table->string('project_name');
                $table->string('description');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
