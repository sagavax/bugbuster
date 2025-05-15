<?php
// env.php – jednoduchý .env loader bez externých knižníc

function loadEnv(string $path = __DIR__ . '/.env', array $requiredKeys = []): void
{
    if (!file_exists($path)) {
        die("❌ .env súbor neexistuje na ceste: $path");
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        // Preskočí komentáre a prázdne riadky
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, "\"' \t\n\r");

        $_ENV[$key] = $value;
    }

    // Over požadované premenné
    foreach ($requiredKeys as $key) {
        if (!isset($_ENV[$key]) || $_ENV[$key] === '') {
            die("❌ Chýba požadovaná premenná v .env: $key");
        }
    }
}
