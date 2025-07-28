<?php

// Simple migration runner for call tables
// Run this by accessing: /run_migrations.php in browser or run via CLI

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;

// Database configuration (adjust these to match your settings)
$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'mangxahoi', // Change this to your database name
    'username' => 'root',       // Change this to your username
    'password' => '',           // Change this to your password
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

echo "<h2>Running Call System Migrations...</h2>\n";

try {
    // Create calls table
    if (!Capsule::schema()->hasTable('calls')) {
        Capsule::schema()->create('calls', function ($table) {
            $table->id();
            $table->string('call_id')->unique();
            $table->unsignedBigInteger('caller_id');
            $table->unsignedBigInteger('receiver_id');
            $table->enum('call_type', ['voice', 'video']);
            $table->enum('status', ['initiating', 'ringing', 'connected', 'ended', 'declined', 'missed']);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->integer('duration_seconds')->nullable();
            $table->json('signaling_data')->nullable();
            $table->timestamps();

            $table->index(['caller_id', 'receiver_id']);
            $table->index(['status']);
            $table->index(['created_at']);
        });
        echo "✅ Created 'calls' table<br>\n";
    } else {
        echo "ℹ️ Table 'calls' already exists<br>\n";
    }

    // Create call_signals table
    if (!Capsule::schema()->hasTable('call_signals')) {
        Capsule::schema()->create('call_signals', function ($table) {
            $table->id();
            $table->string('call_id');
            $table->unsignedBigInteger('sender_id');
            $table->enum('signal_type', ['offer', 'answer', 'ice-candidate', 'test']);
            $table->json('signal_data');
            $table->boolean('processed')->default(false);
            $table->timestamps();

            $table->index(['call_id']);
            $table->index(['processed']);
            $table->index(['created_at']);
        });
        echo "✅ Created 'call_signals' table<br>\n";
    } else {
        echo "ℹ️ Table 'call_signals' already exists<br>\n";
    }

    echo "<br><h3>✅ Migration completed successfully!</h3>\n";
    echo "<p>Now you can test the call functionality:</p>\n";
    echo "<ul>\n";
    echo "<li><a href='/call-test'>Test Page</a> - Check WebRTC and API</li>\n";
    echo "<li><a href='/search?type=user&q=test'>Search Users</a> - Find users to call</li>\n";
    echo "<li><a href='/chat'>Chat</a> - Call from chat interface</li>\n";
    echo "</ul>\n";

} catch (Exception $e) {
    echo "<h3>❌ Migration failed:</h3>\n";
    echo "<p style='color: red;'>" . $e->getMessage() . "</p>\n";
    echo "<p>Please check your database configuration and make sure the database exists.</p>\n";
}

?>

<style>
body { font-family: Arial, sans-serif; margin: 40px; }
h2, h3 { color: #333; }
ul { margin: 10px 0; }
li { margin: 5px 0; }
a { color: #007bff; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>