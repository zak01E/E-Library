<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check user with ID 1
$user = \App\Models\User::find(1);

if ($user) {
    echo "User #1 found:\n";
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Is Author: " . ($user->role === 'author' ? 'Yes' : 'No') . "\n";
} else {
    echo "User #1 not found\n";
}

echo "\n--- Authors in database ---\n";
$authors = \App\Models\User::where('role', 'author')->limit(10)->get();
echo "Total authors: " . \App\Models\User::where('role', 'author')->count() . "\n\n";

foreach ($authors as $author) {
    echo "ID: {$author->id} - Name: {$author->name} - Books: " . $author->books()->count() . "\n";
}