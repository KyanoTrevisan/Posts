<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConversationsTable extends Migration
{
    public function up()
    {
        // Drop the table if it exists
        Schema::dropIfExists('conversations');

        // Create the conversations table
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user1_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('user2_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Add the conversation_id column to the messages table
        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('conversation_id')->nullable()->constrained('conversations')->onDelete('cascade');
        });

        // Populate conversation_id for existing messages if needed.
        // This assumes you have logic to determine the conversation for existing messages.
        DB::table('messages')->update(['conversation_id' => 1]); // Example: Set all existing messages to conversation_id 1.

        Schema::table('messages', function (Blueprint $table) {
            $table->foreignId('conversation_id')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['conversation_id']);
            $table->dropColumn('conversation_id');
        });

        Schema::dropIfExists('conversations');
    }
}
