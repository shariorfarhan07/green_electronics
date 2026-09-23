<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddUserIdToOrders extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Orders were previously stored with only a typed-in name/email, so a
            // customer had no way to see their own order history.
            $table->foreignId('user_id')->nullable()->after('id')
                ->constrained('users')->nullOnDelete();
        });

        // Attach existing orders to accounts by matching the email used at checkout.
        DB::statement('UPDATE orders o JOIN users u ON u.email = o.email SET o.user_id = u.id WHERE o.user_id IS NULL');
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
