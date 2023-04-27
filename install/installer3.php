<title>Passaggio 3 - Creazione tabella Planner</title>
<?php
include 'config2.php';

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// sql to create table
$sql = "CREATE TABLE planner (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
titolo VARCHAR(255) NOT NULL,
descrizione TEXT,
data VARCHAR(25) NOT NULL,
ora VARCHAR(25) NOT NULL,
durata VARCHAR(25) NOT NULL,
organizzatore VARCHAR(255) NOT NULL,
luogo VARCHAR(255) NOT NULL,
tipo TEXT NOT NULL,
link_prenotazione VARCHAR(500),
link_foto_video VARCHAR(500),
data_modifica VARCHAR(255),
validity TEXT
)";

if (mysqli_query($conn, $sql)) {
  echo "Tabella 'planner' creata con successo\n";
  echo "<a href=\"installer4.php\"><button>Procedi>></button></a>";
} else {
  echo "Errore durante la creazione della tabella 'planner': " . mysqli_error($conn);
}

mysqli_close($conn);
?>
