<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginFieldsToAccountsTable extends Migration
{
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('accounts', 'created_at')) {
                $table->timestamps();
            }

            if (!Schema::hasColumn('accounts', 'is_active')) {
                $table->boolean('is_active')->default(false);
            }

            if (!Schema::hasColumn('accounts', 'last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'last_login_at']);
        });
    }
}