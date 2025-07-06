<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->boolean('notified_due_soon')->default(false)->after('due_date');
        });
    }
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('notified_due_soon');
        });
    }
};
