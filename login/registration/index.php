<?php
session_start();
include "../../default.php";

if (isset($_POST['submit'])) {
    $associazione = $_POST['nome_associazione'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $ao = $_POST['ao'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $psw = $_POST['psw'];
    $psw2 = $_POST['psw2'];

    // Cartella temporanea del file da caricare
    $userfile_tmp = $_FILES['locandina']['tmp_name'];
    // Nome del file da caricare
    $userfile_name = $_FILES['locandina']['name'];
    // Dimensione del file da caricare
    $userfile_size = $_FILES['locandina']['size'];
    // Estensione del file da caricare
    $userfile_extension = strtolower(pathinfo($userfile_name,PATHINFO_EXTENSION));

    // Verifico se il file ha il formato corretto in base all'estensione
    $filetypes = array("png", "gif", "jpg", "jpeg");
    if (!in_array($userfile_extension, $filetypes))
    {
        echo "I file di estensione <b>.".$userfile_extension."</b> non sono ammessi.";
        exit;
    }
}
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
            .input-container {margin-bottom: 25px;}

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
                    value=""
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
                    value=""
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
                    value=""
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
            <select name="ao" required>
                <option value="" selected disabled><span style="color: red; font-weight:bold;">*</span> Scegli</option>
                <option value="o">Maschio</option>
                <option value="a">Femmina</option>
                <option value="ə">Altro</option>
            </select>
            <!-- Email referente associazione -->
            <div class="input-container">
                <input
                    type="mail"
                    id="email"
                    name="email"
                    value=""
                    required
                    aria-labelledby="label-email"
                    oninput="manageTextInputStyle('email')"
                    onchange="manageTextInputStyle('email')"
                />
                <label class="label" for="email" id="label-email">
                    <div class="text">Indirizzo email referente associazione <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <!-- Username referente associazione -->
            <div class="input-container">
                <input
                    type="text"
                    id="username"
                    name="username"
                    value=""
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
                    value=""
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
                    value=""
                    required
                    aria-labelledby="label-psw2"
                    oninput="manageTextInputStyle('psw2')"
                    onchange="manageTextInputStyle('psw2')"
                />
                <label class="label" for="psw2" id="label-psw2">
                    <div class="text">Ripeti password <span style="color: red; font-weight:bold;">*</span></div>
                </label>
            </div>
            <!-- Area di upload della locandina -->
            <div class="drop-zone">
                <span class="drop-zone__prompt">Trascina qui il logo della tua associazione o clicca per caricarlo <span style="color: red; font-weight:bold;">*</span><br><br>
                <a class="drop-zone__prompt__accepted_filetype"><b>File accettati:</b> .jpg, .jpeg, .png, .gif</a></span>
                <input name="locandina" id="selectfile" class="drop-zone__input" type="file" accept=".jpg, .jpeg, .png, .gif">
            </div>

            <p style="color: red; font-weight: bold;">* Campi obbligatori</p>
            <button type="submit" name="submit" id="submit">Registrati</button>
        </form>
        <script>
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