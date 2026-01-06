<?php
// import_schema.php
$host = 'localhost';
$port = 5432;
$user = 'postgres';
$pass = '1234';
$dbname = 'ecommerce';
$sqlFile = __DIR__ . '/../database_postgresql.sql';

if (!file_exists($sqlFile)) {
    echo "SQL file not found: {$sqlFile}\n";
    exit(1);
}

$content = file_get_contents($sqlFile);
// Find the position after the psql '\c ecommerce' command if present
$marker = "\\c {$dbname}";
$pos = strpos($content, $marker);
if ($pos !== false) {
    $content = substr($content, $pos + strlen($marker));
}

// Remove psql meta-commands (lines starting with backslash) and SQL comments
$lines = explode("\n", $content);
$filtered = [];
foreach ($lines as $line) {
    $trim = trim($line);
    if ($trim === '') continue;
    if ($trim[0] === '\\') continue; // skip psql meta-commands
    if (substr($trim,0,2) === '--') continue; // skip SQL comments
    $filtered[] = $line;
}

$cleanSql = implode("\n", $filtered);

// Split statements by semicolon
$statements = preg_split('/;\s*\n/', $cleanSql);

try {
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $dbh = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    foreach ($statements as $stmt) {
        $s = trim($stmt);
        if ($s === '') continue;
        // Some statements may include remaining semicolons inside (rare); exec each
        $dbh->exec($s);
    }

    echo "Schema imported into '{$dbname}' successfully.\n";
} catch (PDOException $e) {
    echo "Import error: " . $e->getMessage() . "\n";
    exit(1);
}
