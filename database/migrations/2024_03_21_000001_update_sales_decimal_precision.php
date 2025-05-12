<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update sales table
        Schema::table('sales', function (Blueprint $table) {
            // Add new column with 3 decimal places
            $table->decimal('total_amount_new', 10, 3)->after('total_amount');
        });

        // Copy data from old column to new column
        DB::statement('UPDATE sales SET total_amount_new = total_amount');

        Schema::table('sales', function (Blueprint $table) {
            // Drop old column and rename new one
            $table->dropColumn('total_amount');
            $table->renameColumn('total_amount_new', 'total_amount');
        });

        // Update product_sale table
        Schema::table('product_sale', function (Blueprint $table) {
            // Add new column with 3 decimal places
            $table->decimal('unit_price_new', 10, 3)->after('unit_price');
        });

        // Copy data from old column to new column
        DB::statement('UPDATE product_sale SET unit_price_new = unit_price');

        Schema::table('product_sale', function (Blueprint $table) {
            // Drop old column and rename new one
            $table->dropColumn('unit_price');
            $table->renameColumn('unit_price_new', 'unit_price');
        });
    }

    public function down(): void
    {
        // Update sales table
        Schema::table('sales', function (Blueprint $table) {
            // Add new column with 2 decimal places
            $table->decimal('total_amount_old', 10, 2)->after('total_amount');
        });

        // Copy data from new column to old column
        DB::statement('UPDATE sales SET total_amount_old = total_amount');

        Schema::table('sales', function (Blueprint $table) {
            // Drop new column and rename old one
            $table->dropColumn('total_amount');
            $table->renameColumn('total_amount_old', 'total_amount');
        });

        // Update product_sale table
        Schema::table('product_sale', function (Blueprint $table) {
            // Add new column with 2 decimal places
            $table->decimal('unit_price_old', 10, 2)->after('unit_price');
        });

        // Copy data from new column to old column
        DB::statement('UPDATE product_sale SET unit_price_old = unit_price');

        Schema::table('product_sale', function (Blueprint $table) {
            // Drop new column and rename old one
            $table->dropColumn('unit_price');
            $table->renameColumn('unit_price_old', 'unit_price');
        });
    }
}; 