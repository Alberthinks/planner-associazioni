<title>Passaggio 4 - Inserimento Manutenzione</title>
<?php
include 'config.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$pass = password_hash("cambiami", PASSWORD_BCRYPT);
$nome = cripta("Pewn", "encrypt");
$cogn = cripta("di Zelo", "encrypt");
$o = cripta("o", "encrypt");
$uname = cripta("maintenance", "encrypt");
$mail = cripta("manutenzione@fakemail.xx", "encrypt");
$org = cripta("I.I.S. Primo Levi - Badia Polesine", "encrypt");
$log = cripta("logos/iisplevi.jpg","encrypt");
$sql = "INSERT INTO users (nome, cognome, ao, username, password, email, nome_societa, logo, last_access)
VALUES ('$nome', ' ', '$o', '$uname', '$pass', '$mail', '$org', '$log', ' ')";

if ($conn->query($sql) === TRUE) {
  echo "<p>Il tuo account &egrave; stato inserito correttamente</p>\n";
  echo "<p><b>Username:</b> maintenance<br><b>Password:</b> cambiami</p>\n";
  echo "<a href=\"#\" onclick=\"window.close()\"><button>Fine</button></a>";
} else {
  echo "Errore: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
