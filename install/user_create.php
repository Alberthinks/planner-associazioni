<title>Passaggio 1.1 - Creazione utente per accedere ai database</title>
<?php

$servername = "localhost";
$username = "root";
$dbname = "users";

// Create connection
$conn = mysqli_connect($servername, $username, "mysql");

// Check connection
if ($conn->connect_error) {
  //die("Connessione fallita:" . $conn->connect_error);
  $conn = mysqli_connect($servername, $username, "");
  if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
  }
}

// Creare l'utente che gestira' i database del planner
$createUser = "CREATE USER 'lele_superuser'@'localhost' IDENTIFIED BY '9kQuc(F[D3G0!c9leeeeE41gr4r4gf5df55we38';";

if ($conn->query($createUser) === TRUE) {
  // Dare una password all'utente che gestira' i database del planner
  $setUserPassword = "GRANT ALL PRIVILEGES ON *.* TO 'lele_superuser'@'localhost';";

  if ($conn->query($setUserPassword) === TRUE) {
    // Concedere i permessi per i database all'utente che gestira' i database del planner
    $setUserPrivileges = "FLUSH PRIVILEGES;";

    if ($conn->query($setUserPrivileges) === TRUE) { 
      echo "Utente creato correttamente\n";
      echo "<a href=\"installer.php\"><button>Procedi>></button></a>";
    } else {
      echo "Errore (C): " . $setUserPrivileges . "<br>" . $conn->error;
    }
  } else {
    echo "Errore (B): " . $setUserPassword . "<br>" . $conn->error;
  }
} else {
  echo "Errore (A): " . $createUser . "<br>" . $conn->error;
}

$conn->close();
?>