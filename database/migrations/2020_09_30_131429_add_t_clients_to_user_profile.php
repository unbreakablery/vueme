<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\UserCreditLog;

class AddTClientsToUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


/*

        UPDATE user_profile SET t_clients = 0;
		UPDATE user_profile A
        INNER JOIN (
        SELECT psychic_id,COUNT(distinct user_id) cou 
        FROM user_credit_log 
        GROUP BY user_credit_log.psychic_id) as B
          ON B.psychic_id = A.user_id 
        SET A.t_clients = B.cou;

*/

        

        Schema::table('user_profile', function (Blueprint $table) {
            $table->integer('t_clients')->nullable()->default(0);
        });
        
        DB::update('update user_profile A
        INNER JOIN (
        SELECT psychic_id,COUNT(distinct user_id) cou 
        FROM user_credit_log 
        GROUP BY user_credit_log.psychic_id) as B
          ON B.psychic_id = A.user_id 
        SET A.t_clients = B.cou;');
   
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profile', function (Blueprint $table) {
            $table->dropColumn('t_clients');
        });
    }
}
