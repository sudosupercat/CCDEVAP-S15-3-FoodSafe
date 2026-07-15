<?php

/* NOTTTTTTTTTTTTTTT FINAL */
/* NOTTTTTTTTTTTTTTT FINAL */
/* NOTTTTTTTTTTTTTTT FINAL */
/* NOTTTTTTTTTTTTTTT FINAL */
/* NOTTTTTTTTTTTTTTT FINAL */

require_once __DIR__ . '/admin_auth.php'; 

$dbUser = 'root';
$dbPass = ''; 
$dbName = 'foodsafe_db'; 

$filename = $dbName . "_" . date("Y-m-d_H-i-s") . ".sql";

$dumpCommand = "\"C:\\xampp\\mysql\\bin\\mysqldump.exe\" -u {$dbUser} " . ($dbPass ? "-p{$dbPass} " : "") . $dbName;

$output = shell_exec($dumpCommand);

if ($output) {
    ob_clean(); 
    
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($output));
    
    echo $output;
    exit();
} else {
    echo "<h1>Export Failed!</h1>";
    echo "<p>Could not generate the database backup. Please ensure your XAMPP mysqldump.exe path is correct: C:\\xampp\\mysql\\bin\\mysqldump.exe</p>";
}
?>