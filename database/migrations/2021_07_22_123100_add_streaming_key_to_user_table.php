<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Services\WhiteLabel;

class AddStreamingKeyToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function (Blueprint $table) {
            $table->string('streaming_key')->nullable();
        });

        $modelCollection = User::where('role_id', '=', "1")->get();
		foreach($modelCollection as $model) {
			//Do your calculation whit old columns and save it in the new column.
			$model->streaming_key = "STRKRS-" . base64_encode($model->id);
			$model->save();
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user', function (Blueprint $table) {
            //
        });
    }
}
