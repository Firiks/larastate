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
        Schema::table('listings', function (Blueprint $table) {
            // add foreign key column
            $table->foreignIdFor(\App\Models\User::class, 'by_user_id' )->constrained('users'); // foreign key constraint to users table
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // drop the foreign key constraint
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['by_user_id']);
        });
    }
};
