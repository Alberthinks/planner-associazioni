<title>Passaggio 3 - Creazione tabella di sistema</title>
<?php
include 'config01.php';

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// sql to create table
$sql = "CREATE TABLE systems (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
appName TEXT NOT NULL,
licenseKey TEXT NOT NULL,
version TEXT NOT NULL,
maintenance TEXT NOT NULL,
installDate TEXT NOT NULL
)";

if (mysqli_query($conn, $sql)) {
  echo "Tabella di sistema creata con successo\n";
  echo "<a href=\"installer04.php\"><button>Procedi>></button></a>";
} else {
  echo "Errore durante la creazione della tabella di sistema: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
