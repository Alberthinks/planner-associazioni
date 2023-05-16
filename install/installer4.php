<title>Passaggio 4 - Inserimento Amministratore</title>
<?php
include 'config.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$pass = password_hash("cambiami", PASSWORD_BCRYPT);
$nome = cripta("admin", "encrypt");
$o = cripta("o", "encrypt");
$uname = cripta("admin", "encrypt");
$mail = cripta("prova@fakemail.xx", "encrypt");
$org = cripta("I.I.S. Primo Levi - Badia Polesine", "encrypt");
$log = cripta("logos/iisplevi.jpg","encrypt");
$sql = "INSERT INTO users (nome, cognome, ao, username, password, email, nome_societa, logo, last_access)
VALUES ('$nome', ' ', '$o', '$uname', '$pass', '$mail', '$org', '$log', ' ')";

if ($conn->query($sql) === TRUE) {
  echo "L'amministratore &egrave; stato aggiunto correttamente\n";
  echo "<a href=\"installer5.php\"><button>Procedi>></button></a>";
} else {
  echo "Errore: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
