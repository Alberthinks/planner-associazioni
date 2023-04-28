<?php
$default_servername = "localhost";
$default_username = "root";
$default_password = "mysql";
$default_dbname = "accesses";

// Nasconde gli errori agli utenti
ini_set("display_errors", false);

// Create connection
$default_conn = mysqli_connect($default_servername, $default_username, $default_password, $default_dbname);
$default_query = mysqli_query($default_conn,"SELECT * FROM systems") or die (mysqli_error($default_conn));
$default_fetch = mysqli_fetch_array($default_query) or die (mysqli_error());

// Nome della piattaforma
$nome_app = $default_fetch['appName'];
// LicenseKey usata per l'attivazione
$licenseKey = $default_fetch['licenseKey'];
// Versione della piattaforma
$version = $default_fetch['version'];

$dataValidity = date('Ymd');
// Stato della modalita' manutenzione (ATTIVATA/DISATTIVATA)
$maintenance = $default_fetch['maintenance'];

// Controllo sulla validita' della LicenseKey
if (!isset($licenseKey) || !is_numeric($licenseKey)) {
    header('Location: /planner-main/settings/error/error.php?status=err5801x24-License-Key');
}

// Controllo se la modalita' manutenzione e' attiva o no
if ($maintenance == "true") {
    // Verifico se l'utente e' il tecnico di manutenzione o l'admin per lasciargli la possibilita' di vedere la piattaforma anche in fase di manutenzione
    if ($_SESSION['session_user_lele_planner_0425'] != "maintenance" && $_SESSION['session_user_lele_planner_0425'] != "lele_administrator_admin") {
        header('Location: /planner-main/settings/error/error.php?status=err5077x26-Maintenance');
    }
    echo "<script>alert('Sei in modalità manutenzione!');</script>";
}

function writeRecord($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function cripta($string, $method) {
    $secretKey = "fdgjgtn544h1th1gb1ff";
    $secretIv = "fg4g4g1t11gfcfss";

    $algorithm = "AES-256-CBC";
    $key = hash("sha256", $secretKey);
    $iv = substr(hash('sha256', $secretIv), 0, 16);

    if ($method == "encrypt") {
        $output = base64_encode(openssl_encrypt($string, $algorithm, $key, 0, $iv));
    }

    if ($method == "decrypt") {
        $output = stripslashes(openssl_decrypt(base64_decode($string), $algorithm, $key, 0, $iv));
    }

    return $output;
}
?>
