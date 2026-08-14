<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Payees move out of the client (company) form into their own module.
        Schema::create('payees', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        $now = now();

        DB::table('clients')
          ->whereNotNull('payee_name')
          ->where('payee_name', '!=', '')
          ->distinct()
          ->pluck('payee_name')
          ->each(function (string $name) use ($now) {
              DB::table('payees')->insertOrIgnore([
                  'name'       => $name,
                  'created_at' => $now,
                  'updated_at' => $now,
              ]);
          });

        // The payee is now chosen per cheque instead of coming from the client.
        Schema::table('cheques', function (Blueprint $table) {
            $table->foreignId('payee_id')->nullable()->after('client_id')
                  ->constrained()->nullOnDelete();
        });

        DB::table('cheques')
          ->join('clients', 'clients.id', '=', 'cheques.client_id')
          ->join('payees', 'payees.name', '=', 'clients.payee_name')
          ->update(['cheques.payee_id' => DB::raw('payees.id')]);

        // A company can now be linked to several banks (many-to-many).
        Schema::create('bank_client', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')->constrained()->cascadeOnDelete();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['bank_id', 'client_id']);
        });

        DB::table('clients')->whereNotNull('bank_id')->get()
          ->each(function ($client) use ($now) {
              DB::table('bank_client')->insertOrIgnore([
                  'bank_id'    => $client->bank_id,
                  'client_id'  => $client->id,
                  'created_at' => $now,
                  'updated_at' => $now,
              ]);
          });

        // The account number now lives on the bank (the renamed fraction field).
        // Seed it from the first client that had an account at that bank.
        DB::table('clients')
          ->whereNotNull('bank_id')
          ->whereNotNull('bank_account_number')
          ->where('bank_account_number', '!=', '')
          ->orderBy('id')
          ->get()
          ->unique('bank_id')
          ->each(function ($client) {
              DB::table('banks')->where('id', $client->bank_id)
                ->update(['bank_account_number' => $client->bank_account_number]);
          });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropConstrainedForeignId('bank_id');
            $table->dropColumn(['payee_name', 'bank_account_number']);
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('payee_name')->nullable();
            $table->foreignId('bank_id')->nullable()->constrained()->nullOnDelete();
            $table->string('bank_account_number')->nullable();
        });

        DB::table('bank_client')->orderBy('id')->get()
          ->each(function ($row) {
              DB::table('clients')->where('id', $row->client_id)
                ->whereNull('bank_id')
                ->update(['bank_id' => $row->bank_id]);
          });

        Schema::dropIfExists('bank_client');

        Schema::table('cheques', function (Blueprint $table) {
            $table->dropConstrainedForeignId('payee_id');
        });

        Schema::dropIfExists('payees');
    }
};
