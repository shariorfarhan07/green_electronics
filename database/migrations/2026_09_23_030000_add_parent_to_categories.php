<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParentToCategories extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Self-referencing parent so the taxonomy is two-level (section -> category)
            // instead of the previous flat list.
            $table->foreignId('parent_id')->nullable()->after('id')
                ->constrained('categories')->nullOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0)->after('blurb');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'sort_order']);
        });
    }
}
