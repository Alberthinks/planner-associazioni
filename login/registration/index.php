<?php
session_start();
include "../../default.php";
include '../../config.php';

$db = 'users';
$conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registrazione | <?php echo $nome_app; ?></title>
        <!-- Icone -->
        <link rel="apple-touch-icon" sizes="180x180" href="../../img/icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../../img/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../../img/icon/favicon-16x16.png">
        <link rel="manifest" href="../../img/icon/site.webmanifest">
        <!-- CSS -->
        <link rel="stylesheet" href="../../css/default.css" type="text/css">
        <link rel="stylesheet" href="../css/style.css" type="text/css">
        <style>
            * {font-family: sans-serif;}
            html, body {background: white;}
            input {width: 100%;}
            .input-container, .drop-zone {margin-top: 25px;}

            select {width: 100%; height: 48px; border-radius: 4px; border: 1px solid #c0c0c0; padding-left: 16px; font-size: 14px;}
            option {font-size: 14px; padding: 8px;}

            .error {color: red; font-weight: bold; display: none;}

            /* Ripple button */
            button {
            font: 16px 'Open Sans', sans-serif;
            background-color: #29b429;
            color: white;
            padding: 10px;
            width: 100%;
            height: 40px;
            border: none;
            margin-top: 10px;
            text-transform: uppercase;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background 400ms;
            -webkit-transition-duration: background 400ms;
            transition-duration: background 400ms;
            text-decoration: none;
            overflow: hidden;
            position: relative;
        }

        span.ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 600ms linear;
            background-color: rgba(255, 255, 255, 0.6);
        }

        @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
        }
        /* Drag & Drop */
        .drop-zone {
		  max-width: 1200px;
		  width: 100%;
		  height: 200px;
		  padding: 25px;
		  display: flex;
		  align-items: center;
		  justify-content: center;
		  text-align: center;
		  font-family: "Quicksand", sans-serif;
		  font-weight: 500;
		  font-size: 22px;
		  cursor: pointer;
		  color: #777;
		  border: 4px dashed #BBB;
		  border-radius: 10px;
		  transition: 0.2s;
		  min-width:250px;
		}
		
		.drop-zone:hover {
			background-color: rgba(255,255,255,0.25);
		}

		.drop-zone--over {
		  border-style: solid;
		}

		.drop-zone__input {
		  display: none;
		}

		.drop-zone__thumb {
		  width: 200px;
		  height: 100%;
		  border-radius: 10px;
		  overflow: hidden;
		  background-color: transparent;
		  background-size: auto 80%;
		  background-repeat: no-repeat;
		  background-position-x: 50%;
		  position: relative;
		}

		.drop-zone__thumb::after {
		  content: attr(data-label);
		  position: absolute;
		  bottom: 0;
		  left: 0;
		  width: 100%;
		  padding: 5px 0;
		  color: #ffffff;
		  background: rgba(0, 0, 0, 0.75);
		  font-size: 14px;
		  text-align: center;
		}
		
		.drop-zone__prompt__accepted_filetype {
			font-size: 16px;
			color: #999;
		}
        </style>
        <?php
        if (isset($_POST['submit'])) {
            $associazione = addslashes($_POST['nome_associazione']);
            $nome = addslashes($_POST['nome']);
            $cognome = addslashes($_POST['cognome']);
            $ao = addslashes($_POST['ao']);
            $email = addslashes($_POST['email']);
            $username = addslashes($_POST['username']);
            $psw = $_POST['psw'];
            $psw2 = $_POST['psw2'];

            $uploaddir = '../../settings/gestione-utenti/nuovo/logos/';
            // Cartella temporanea del file da caricare
            $userfile_tmp = $_FILES['locandina']['tmp_name'];
            // Nome del file da caricare
            $userfile_name = $_FILES['locandina']['name'];
            // Dimensione del file da caricare
            $userfile_size = $_FILES['locandina']['size'];
            // Estensione del file da caricare
            $userfile_extension = strtolower(pathinfo($userfile_name,PATHINFO_EXTENSION));

            // Flag per controllare se e' tutto aposto o se l'utente ha commesso degli errori
            $isCorrect = false;

            // Cambio il nome del file per evitare che ci siano 2 o + loghi con lo stesso nome
            $userfile_name = "logo_".date("hisdmY", time()).".".$userfile_extension;

            $logo = cripta("logos/".$userfile_name, "encrypt");
            
            // Verifico se il file ha il formato corretto in base all'estensione
            $filetypes = array("png", "gif", "jpg", "jpeg");
            if ($userfile_extension == "")
            {
                echo "<style>#no_logo {display: block !important;}</style>";
            } elseif (!in_array($userfile_extension, $filetypes))
            {
                echo "<style>#wrong_extension {display: block !important;}</style>";
            } else {
                $isCorrect = true;
            }

            // Controllo che le 2 password inserite corrispondano
            if ($psw != $psw2) {
                echo "<style>#psw2_err {display: block !important;}</style>";
                $isCorrect = false;
            } else {
                $isCorrect = true;
                // Cripto la password
                $psw = password_hash($psw, PASSWORD_BCRYPT);
            }

            // Controllo che l'email sia scritta con un formato valido
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                echo "<style>#email_err {display: block !important;}</style>";
                $isCorrect = false;
            } else {
                $isCorrect = true;
            }

            // Se e' tutto ok
            if ($isCorrect) {

                $associazione_db = cripta(addslashes($associazione),'encrypt');
                $nome_db = cripta(addslashes($nome),'encrypt');
                $cognome_db = cripta(addslashes($cognome),'encrypt');
                $ao_db = cripta(addslashes($ao),'encrypt');
                $email_db = cripta(addslashes($email),'encrypt');
                $username_db = cripta(addslashes($username),'encrypt');

                $sql = "INSERT INTO users (nome,cognome,ao,username,password,email,nome_societa,logo,last_access) VALUES ('$nome_db', '$cognome_db','$ao_db','$username_db','$psw','$email_db','$associazione_db','$logo','')";
                
                if (!file_exists($uploaddir.$userfile_name) && move_uploaded_file($userfile_tmp, $uploaddir.$userfile_name)) {
                    if ($result = mysqli_query($conn,$sql) or die (mysqli_error($conn))) {
                        echo "</head><body style='padding: 25px;'><h1>Registrazione alla piattaforma avvenuta correttamente!</h1><p>Usa le credenziali inserite prima (username e password) per <a href='../' style='color: #0071e6; text-decoration:underline;'>accedere</a>.</p></body></html>";
                        exit;
                    }
                }
            }
        }
        ?>
    </head>
    <body>
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off" class="form">
            <h1>Registrazione associazioni</h1>
            <!-- Nome associazione -->
            <div class="input-container">
                <input
                    type="text"
                    id="nome_associazione"
                    name="nome_associazione"
                    value="<?php echo $associazione; ?>"
                    autofocus
                    required
                    aria-labelledby="label-nome_associazione"
                    oninput="manageTextInputStyle('nome_associazione')"
                    onchange="manageTextInputStyle('nome_associazione')"
                />
                <label class="label" for="nome_associazione" id="label-nome_associazione">
                    <div class="text">Nome associazione <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <!-- Nome referente associazione -->
            <div class="input-container">
                <input
                    type="text"
                    id="nome"
                    name="nome"
                    value="<?php echo $nome; ?>"
                    required
                    aria-labelledby="label-nome"
                    oninput="manageTextInputStyle('nome')"
                    onchange="manageTextInputStyle('nome')"
                />
                <label class="label" for="nome" id="label-nome">
                    <div class="text">Nome referente associazione <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <!-- Cognome referente associazione -->
            <div class="input-container">
                <input
                    type="text"
                    id="cognome"
                    name="cognome"
                    value="<?php echo $cognome; ?>"
                    required
                    aria-labelledby="label-cognome"
                    oninput="manageTextInputStyle('cognome')"
                    onchange="manageTextInputStyle('cognome')"
                />
                <label class="label" for="cognome" id="label-cognome">
                    <div class="text">Cognome referente associazione <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <!-- Sesso referente associazione -->
            <div class="input-container">
                <select name="ao" required>
                    <option value="" selected disabled><span style="color: red; font-weight:bold;">*</span> Scegli</option>
                    <option value="o">Maschio</option>
                    <option value="a">Femmina</option>
                    <option value="ə">Altro</option>
                </select>
            </div>
            <!-- Email referente associazione -->
            <div class="input-container">
                <input
                    type="text"
                    id="email"
                    name="email"
                    value="<?php echo $email; ?>"
                    required
                    aria-labelledby="label-email"
                    oninput="manageTextInputStyle('email')"
                    onchange="manageTextInputStyle('email')"
                />
                <label class="label" for="email" id="label-email">
                    <div class="text">Indirizzo email referente associazione <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <p class="error" id="email_err">Il formato dell'indirizzo email fornito non &egrave; valido!</p>
            <!-- Username referente associazione -->
            <div class="input-container">
                <input
                    type="text"
                    id="username"
                    name="username"
                    value="<?php echo $username; ?>"
                    required
                    aria-labelledby="label-username"
                    oninput="manageTextInputStyle('username')"
                    onchange="manageTextInputStyle('username')"
                />
                <label class="label" for="username" id="label-username">
                    <div class="text">Username <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <!-- Password referente associazione -->
            <div class="input-container">
                <input
                    type="password"
                    id="psw"
                    name="psw"
                    value="<?php echo $psw; ?>"
                    required
                    aria-labelledby="label-psw"
                    oninput="manageTextInputStyle('psw')"
                    onchange="manageTextInputStyle('psw')"
                />
                <label class="label" for="psw" id="label-psw">
                    <div class="text">Password <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <!-- Ripeti password referente associazione -->
            <div class="input-container">
                <input
                    type="password"
                    id="psw2"
                    name="psw2"
                    value="<?php echo $psw2; ?>"
                    required
                    aria-labelledby="label-psw2"
                    oninput="manageTextInputStyle('psw2')"
                    onchange="manageTextInputStyle('psw2')"
                />
                <label class="label" for="psw2" id="label-psw2">
                    <div class="text">Ripeti password <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <p class="error" id="psw2_err">Le due password non corrispondono!</p>
            <!-- Area di upload della locandina -->
            <div class="drop-zone">
                <span class="drop-zone__prompt">Trascina qui il logo della tua associazione o clicca per caricarlo <span style="color: red; font-weight:bold;">*</span><br><br>
                <a class="drop-zone__prompt__accepted_filetype"><b>File accettati:</b> .jpg, .jpeg, .png, .gif</a></span>
                <input name="locandina" id="selectfile" class="drop-zone__input" type="file" accept=".jpg, .jpeg, .png, .gif">
            </div>
            <p class="error" id="no_logo">Non &egrave; stato caricato nessun logo!</p>
            <p class="error" id="wrong_extension">I file di estensione <b>.<?php echo $userfile_extension; ?></b> non sono ammessi.</p>

            <input type="checkbox" name="app" id="app" style="width: 15px; height: 15px; margin-top: 30px;" oninput="registraAPP()">
            <label for="app">Voglio registrare la mia associazione anche nell'app per dispositivi Android.</label>

            <p style="color: red; font-weight: bold;">* Campi obbligatori</p>
            <button type="submit" name="submit" id="submit">Registrati</button>
        </form>

        <!-- Form di registrazione associazione nell'app -->
        <div id="registerForm" style="display: none; background-color: #fff; width: 50%; min-width: 600px; height: 480px; position: fixed; top: 25%; bottom: 25%; left: 25%; right: 25%; z-index: 7; border-radius: 15px; box-shadow: 0 0 15px #333;">
            <iframe style="width: 100%; height: 100%;" frameborder="0" marginheight="0" marginwidth="0" id="registerFrame">Caricamento…</iframe>
        </div>
        <div onclick="closeRegister()" id="background_div" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 6; background: rgba(0, 0, 0, 0.5);"></div>

        <script>
        // Registrare l'associazione anche nell'app
        function registraAPP() {
            var registerForm = document.getElementById("registerForm");
            var registerDiv = document.getElementById("background_div");
            registerForm.style.display = "block";
            registerDiv.style.display = "block";
            document.getElementById("registerFrame").setAttribute("src", "https://docs.google.com/forms/d/e/1FAIpQLSfNiRvbThyuhli4xCuTLLYd4EvWQKTaIO8HdS39caa_4_Jmow/viewform?embedded=true");
        }
        
        function closeRegister() {
            var registerForm = document.getElementById("registerForm");
            var registerDiv = document.getElementById("background_div");
            registerForm.style.display = "none";
            registerDiv.style.display = "none";
        }

        // Gestire i campi di testo
        function manageTextInputStyle(id) {
            const input = document.getElementById(id);
            input.setAttribute('value', input.value);
        }

        // Ripple button
        function createRipple(event) {
            const button = document.querySelector("button");

            const circle = document.createElement("span");
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - button.offsetLeft - radius}px`;
            circle.style.top = `${event.clientY - button.offsetTop - radius}px`;
            circle.classList.add("ripple");

            const ripple = button.getElementsByClassName("ripple")[0];

            if (ripple) {
                ripple.remove();
            }

            button.appendChild(circle);
            }

            const buttons = document.getElementsByTagName("button");
            for (const button of buttons) {
            button.addEventListener("mousedown", createRipple);
            }

            // Upload logo associazione
            document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
            const dropZoneElement = inputElement.closest(".drop-zone");

            dropZoneElement.addEventListener("click", (e) => {
                inputElement.click();
            });

            inputElement.addEventListener("change", (e) => {
                if (inputElement.files.length) {
                updateThumbnail(dropZoneElement, inputElement.files[0]);
                }
            });

            dropZoneElement.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropZoneElement.classList.add("drop-zone--over");
            });

            ["dragleave", "dragend"].forEach((type) => {
                dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--over");
                });
            });

            dropZoneElement.addEventListener("drop", (e) => {
                e.preventDefault();

                if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                }

                dropZoneElement.classList.remove("drop-zone--over");
            });
            });

            /**
             * Updates the thumbnail on a drop zone element.
             *
             * @param {HTMLElement} dropZoneElement
             * @param {File} file
             */

            function updateThumbnail(dropZoneElement, file) {
            let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

            // First time - remove the prompt
            if (dropZoneElement.querySelector(".drop-zone__prompt")) {
                dropZoneElement.querySelector(".drop-zone__prompt").remove();
            }

            // First time - there is no thumbnail element, so lets create it
            if (!thumbnailElement) {
                thumbnailElement = document.createElement("div");
                thumbnailElement.classList.add("drop-zone__thumb");
                dropZoneElement.appendChild(thumbnailElement);
            }

            thumbnailElement.dataset.label = file.name;

            // Show thumbnail for image files
            if (file.type.startsWith("image/")) {
                const reader = new FileReader();

                reader.readAsDataURL(file);
                reader.onload = () => {
                thumbnailElement.style.backgroundImage = 'url('+reader.result+')';
                thumbnailElement.style.backgroundColor = "transparent";
                };
            }  else {
                thumbnailElement.style.backgroundImage = null;
                thumbnailElement.style.backgroundColor = "#cccccc";
            }
            console.log(file.type);
            }
        </script>
    </body>
</html>