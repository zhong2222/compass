<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likes', function (Blueprint $table) {
            //テーブル追加
            $table->foreignId('user_id')->after('id');
            $table->foreignId('project_id')->after('user_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('likes', function (Blueprint $table) {
             //テーブル追加の取り消し
            $table->dropColumn('user_id');
            $table->dropColumn('project_id');
        });
    }
};
