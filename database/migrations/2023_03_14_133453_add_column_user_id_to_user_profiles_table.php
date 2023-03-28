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
        Schema::table('user_profiles', function (Blueprint $table) {
             //テーブル追加
            $table->foreignId('user_id')->after('id');
            $table->string('realname')->after('user_id');
            $table->text('bio')->after('realname');
            $table->text('icon')->after('bio');
            $table->text('status')->after('icon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->dropColumn('realname');
            $table->dropColumn('bio');
            $table->dropColumn('icon');
            $table->dropColumn('status');
        });
    }
};
