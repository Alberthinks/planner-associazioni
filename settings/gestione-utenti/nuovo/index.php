<?php
session_start();

include "../../../default.php";

$nome = $_SESSION['session_user_lele_planner_0425'];
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../../css/default.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <title>Aggiungi un nuovo utente</title>
    </head>
    <body>
        <?php
        // Permette l'accesso solo all'amministratore
        if (isset($_SESSION['session_id_lele_planner_0425']) && $_SESSION['session_user_lele_planner_0425'] == "lele_administrator_admin") {
            if (isset($_POST['submit']) && $_POST['submit']=="Registra utente") {
                $nome = cripta(addslashes($_POST['nome']),'encrypt');
                $cognome = cripta(addslashes($_POST['cognome']),'encrypt');
                $email = cripta(addslashes($_POST['email']),'encrypt');
                $password = addslashes($_POST['password']);
                $nome_societa = cripta(addslashes($_POST['nome_societa']),'encrypt');
                $last_access = "";
                $ao = cripta(addslashes($_POST['ao']),'encrypt');
                $username = cripta(addslashes($_POST['username']),'encrypt');
                $passuord = password_hash($password, PASSWORD_BCRYPT);

                // Percorso della cartella dove mettere i file caricati dagli utenti
                $uploaddir = 'logos/';

                // Cartella temporanea del file da caricare
                $userfile_tmp = $_FILES['logo']['tmp_name'];

                // Nome del file da caricare
                $userfile_name = $_FILES['logo']['name'];

                // Dimensione del file da caricare
                $userfile_size = $_FILES['logo']['size'];

                // Estensione del file da caricare
                $userfile_extension = strtolower(pathinfo($userfile_name,PATHINFO_EXTENSION));

                $logo = cripta($uploaddir.$userfile_name, "encrypt");

                include '../../../config.php';
                $db = 'users';
                $conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());

                $sql = "INSERT INTO users (nome,cognome,ao,username,password,email,nome_societa,logo,last_access) VALUES ('$nome', '$cognome','$ao','$username','$passuord','$email','$nome_societa','$logo','$last_access')";
			    if($result = mysqli_query($conn,$sql) or die (mysqli_error($conn))) {
                    if (!file_exists($uploaddir . $userfile_name) && move_uploaded_file($userfile_tmp, $uploaddir . $userfile_name)) {
                        echo "<script>location.href = \"../../\";</script>";
                    } else {
                        echo "Errore nel caricamento del logo";
                    }
                } else {
                    echo "Errore nella registrazione dei dati";
                }
            } else {
        ?>
        <!-- Header -->
        <header>
            Benvenuto, <?php echo $nome; ?>
            <a href="../../../login/logout.php" class="material-icons headerbutton">logout</a>
        </header>
        <!-- Titolo -->
        <h1>Aggiungi un nuovo utente</h1>
        <!-- Form per inserire il nuovo utente -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" autocomplete="off">
            <p>Non usare n&eacute; apici singoli n&eacute; apici doppi (' o ")</p>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome"><br>

            <label for="cognome">Cognome:</label>
            <input type="text" name="cognome" id="cognome"><br>

            <label for="ao">Sesso:</label>
            <input type="radio" name="ao" id="ao" value="o"> Maschio
            <input type="radio" name="ao" id="ao" value="a"> Femmina<br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email"><br>

            <label for="username">Username:</label>
            <input type="text" name="username" id="username"><br>

            <label for="password">Password:</label>
            <input type="text" name="password" id="password"><br>

            <label for="nome_societa">Nome associazione:</label>
            <input type="text" name="nome_societa" id="nome_societa"><br>

            <label for="logo">Logo dell'associazione:</label>
            <input type="file" name="logo" id="logo" accept="image/*"><br>

            <input type="submit" name="submit" value="Registra utente">
        </form>
        <?php
            }
        } else {
            // Se non si è l'amministratore, si viene mandati alla pagina principale
            echo "<script type=\"text/javascript\">location.replace(\"../../\");</script>";
        }
        ?>
    </body>
</html>
