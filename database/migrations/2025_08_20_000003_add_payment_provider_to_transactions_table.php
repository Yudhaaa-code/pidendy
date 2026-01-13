<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('transactions', function (Blueprint $table) {
			$table->enum('payment_provider', ['bca', 'bni', 'mandiri', 'dana', 'ovo', 'gopay'])->nullable()->after('payment_method');
		});
	}

	public function down(): void
	{
		Schema::table('transactions', function (Blueprint $table) {
			$table->dropColumn('payment_provider');
		});
	}
}; 