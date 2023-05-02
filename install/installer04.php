<title>Passaggio 4 - Inserimento Manutenzione</title>
<?php
include 'config01.php';

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit']) && isset($_POST['licenseKey'])) {
$installDate = date("d/m/Y");
$licenseKey = $_POST['licenseKey'];

$sql = "INSERT INTO systems (appName,licenseKey,version,maintenance,installDate)
VALUES ('Planner associazioni','$licenseKey','05/2023','false','$installDate')";

if ($conn->query($sql) === TRUE) {
  echo "<p>Il database di sistema &egrave; stato creato e configurato correttamente.</p>\n";
  echo "<a href=\"#\" onclick=\"window.close()\"><button>Fine</button></a>";
} else {
  echo "Errore: " . $sql . "<br>" . $conn->error;
}
} else {
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" method="post">
    <label for="licenseKey">Inserire la License Key:</label><br>
    <input type="number" name="licenseKey" id="licenseKey">
    <input type="submit" name="submit">
</form>
<?php
}

$conn->close();
?>
