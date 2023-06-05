<?php
session_start();
include "../default.php";

$str_data = $_GET['data'];
$data = date("Y-m-d", $str_data);

$username = $_SESSION['session_user_lele_planner_0425'];
$nome = $_SESSION['session_nome_lele_planner_0425'];
$cognome = $_SESSION['session_cognome_lele_planner_0425'];
$ao = $_SESSION['session_ao_lele_planner_0425'];
$nome_societa = $_SESSION['session_nome-societa_lele_planner_0425'];
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Icone -->
        <link rel="apple-touch-icon" sizes="180x180" href="../img/icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../img/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../img/icon/favicon-16x16.png">
        <link rel="manifest" href="../img/icon/site.webmanifest">
        <!-- Titolo -->
        <title>Nuovo evento | <?php echo $nome_app; ?></title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link rel="stylesheet" href="../css/default.css" type="text/css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <!-- Header -->
        <header>
            <div class="logo"><a href="../"><img src="../img/logo.png"></a></div>  
            <?php
            if (isset($_SESSION['session_id_lele_planner_0425'])) {
            ?>
            <div class="header-scritte">
                Benvenut<?php echo $ao; ?>, <div class="evidenziato user_name"><?php echo $nome." ".$cognome; ?>
                    <div class="user_actions">
                        <a href="../account/"><i class="material-icons">manage_accounts</i> Gestisci il tuo account</a>
                        <?php
                        if ($_SESSION['session_user_lele_planner_0425'] == "lele_administrator_admin" || $_SESSION['session_user_lele_planner_0425'] == "maintenance") {
                        ?>
                        <hr>
                        <a href="../settings/"><i class="material-icons">settings</i> Impostazioni</a>
                        <?php
                        }
                        ?>
                        <hr>
                        <a href="../login/logout.php"><i class="material-icons">logout</i> Esci</a>
                    </div>
                </div>
            </div>

            <div class="logout">
                <div class="tooltip"><a href="../login/logout.php" class="material-icons headerbutton">logout</a>
                    <span class="tooltiptext">Logout</span>
                </div>
            </div>
            <?php
            } else {
            ?>
            <div class="header-scritte"><a href="../login" class="evidenziato">Accedi</a> per inserire nuovi eventi</div>
            <div class="logout">
                <div class="tooltip">
                    <a href="login" class="material-icons headerbutton">login</a>
                    <span class="tooltiptext">Login</span>
                </div>
            </div>
            <?php
            }
            ?>
        </header>
            <?php
            if (isset($_SESSION['session_id_lele_planner_0425'])) {

            if (isset($_POST['submit']) && $_POST['submit']=="Crea evento") {
                $titolo = writeRecord($_POST['titolo']);
                $descrizione = writeRecord($_POST['descrizione']);
                $data = strtotime(writeRecord($_POST['data']));
                $ora = writeRecord($_POST['ora']);
                $ore = writeRecord($_POST['ore']);
                if ($ore == 1) {
                    $ore = $ore." ora";
                } elseif ($ore == 0) {
                    $ore = "";
                } else {
                    $ore = $ore." ore";
                }
                $minuti = writeRecord($_POST['minuti']);
                if ($minuti == 1) {
                    $minuti = " e ".$minuti." minuto";
                } elseif ($ore == 0) {
                    $minuti = $minuti." minuti";
                } else {
                    $minuti = " e ".$minuti." minuti";
                }
                $durata = $ore.$minuti;
                $organizzatore = writeRecord($_POST['organizzatore']);
                $luogo = writeRecord($_POST['luogo']);
                $tipo = writeRecord($_POST['tipo']);
                $link_prenotazione = writeRecord($_POST['link_prenotazione']);
                $data_modifica = writeRecord($_POST['data_modifica']);

                // Percorso della cartella dove mettere i file caricati dagli utenti
                $uploaddir = '../evento/locandine/';

                include '../config.php';

                $db = 'planner';
                $conn = mysqli_connect($host,$user,$pass, $db) or die (mysqli_error());

                $myconn = mysqli_connect('localhost','root','mysql', 'accesses') or die (mysqli_error());
                $timestamp = cripta(date('d/m/Y H:i:s', strtotime("now")), "encrypt");
                $action = cripta("Creazione dell'evento '$titolo' del ".date('d/m/Y', $data)." alle $ora", "encrypt");
                $ip = cripta($_SERVER['REMOTE_ADDR'], "encrypt");
                $uname = cripta($username, "encrypt");
                $name = cripta($nome, "encrypt");
                $cog = cripta($cognome, "encrypt");
                $societa = cripta($nome_societa, "encrypt");
                $mysql = "INSERT INTO accesses (username,nome,cognome,nome_societa,ip,azione,timestamp,validity) VALUES ('$uname', '$name','$cog','$societa','$ip','$action','$timestamp','$dataValidity')";
            
                
                if (($_FILES['locandina']['name'] != null) && ($_FILES['locandina']['tmp_name'] != null)) {
                    // Cartella temporanea del file da caricare
                    $userfile_tmp = $_FILES['locandina']['tmp_name'];
                    // Nome del file da caricare
                    $userfile_name = $_FILES['locandina']['name'];
                    // Dimensione del file da caricare
                    $userfile_size = $_FILES['locandina']['size'];
                    // Estensione del file da caricare
                    $userfile_extension = strtolower(pathinfo($userfile_name,PATHINFO_EXTENSION));

                    // Verifico se il file ha il formato corretto in base all'estensione
                    $filetypes = array("png", "gif", "jpg", "jpeg", "svg");
                    if (!in_array($userfile_extension, $filetypes))
                    {
                        echo "I file di estensione <b>.".$userfile_extension."</b> non sono ammessi.";
                        exit;
                    }

                    $userfile_name = "file_".date("hisdmY", time()).".".$userfile_extension;
                    
                    // Inserisco i dati dell'evento nel database "planner"
                    $sql = "INSERT INTO planner (titolo,descrizione,data,ora,durata,organizzatore,luogo,tipo,link_prenotazione,link_foto_video,data_modifica,validity) VALUES ('$titolo', '$descrizione','$data','$ora','$durata','$organizzatore','$luogo','$tipo','$link_prenotazione','$userfile_name','$data_modifica','$dataValidity')";
                    
                    // Controllo se esiste gia' un file con lo stesso nome e se sono in grado di caricare il file corrente
                    if (!file_exists($uploaddir.$userfile_name) && move_uploaded_file($userfile_tmp, $uploaddir.$userfile_name)) {
                        if ($result = mysqli_query($conn,$sql) or die (mysqli_error($conn))) {
                            if ($rressultt = mysqli_query($myconn,$mysql) or die (mysqli_error($myconn))) {
                                echo "<script type=\"text/javascript\">location.replace(\"../\");</script>";
                            }
                        }
                    } elseif (file_exists($uploaddir.$userfile_name)) {
                        echo "Il file esiste gi&agrave;!";
                    } else {
                        echo "Errore!";
                    }
                } else {
                    // Inserisco i dati dell'evento nel database "planner"
                    $sql = "INSERT INTO planner (titolo,descrizione,data,ora,durata,organizzatore,luogo,tipo,link_prenotazione,link_foto_video,data_modifica,validity) VALUES ('$titolo', '$descrizione','$data','$ora','$durata','$organizzatore','$luogo','$tipo','$link_prenotazione','locandina_default.png','$data_modifica','$dataValidity')";

                    if ($result = mysqli_query($conn,$sql) or die (mysqli_error($conn))) {
                        if ($rressultt = mysqli_query($myconn,$mysql) or die (mysqli_error($myconn))) {
                            echo "<script type=\"text/javascript\">location.replace(\"../\");</script>";
                        }
                    }
                }

            }
            
            date_default_timezone_set('Europe/Rome');
            ?>
        <div class="container">
            <div class="main_container">
                <div class="left_content">
                    <!-- Titolo -->
                    <h1>Nuovo evento</h1>
                    <form name="crea" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                        <input type="hidden" name="data_modifica" value="<?php echo(date("d/m/Y h:i:s A",time())); ?>">
                        <p>
                            <!-- Titolo evento -->
                            <div class="input-container">
                                <input
                                    type="text"
                                    id="titolo"
                                    name="titolo"
                                    value=""
                                    aria-labelledby="label-titolo"
                                    oninput="manageTextInputStyle('titolo')"
                                    required
                                />
                                <label class="label" for="titolo" id="label-titolo">
                                    <div class="text">Titolo</div>
                                </label>
                            </div>
                        </p>
                        <p>
                            <!-- Descrizione evento -->
                            <div class="input-container">
                                <input
                                    type="text"
                                    id="descrizione"
                                    name="descrizione"
                                    value=""
                                    aria-labelledby="label-descrizione"
                                    style="resize: both;"
                                    oninput="manageTextInputStyle('descrizione')"
                                />
                                <label class="label" for="descrizione" id="label-descrizione">
                                    <div class="text">Descrizione (facoltativa)</div>
                                </label>
                            </div>
                        </p>
                        <p>
                            <div class="input-container">
                                <input type="date" name="data" id="data" aria-labelledby="label-data" value="<?php echo $data; ?>" required>
                                <label for="data" class="fixed_label" id="label-data">Data dell'evento</label>
                            </div>
                        </p>
                        <p>
                            <div class="input-container">
                                <input type="time" name="ora" id="ora" aria-labelledby="label-ora" required>
                                <label for="ora" class="fixed_label" id="label-ora">Ora di inizio</label>
                            </div>
                        </p>
                        <p>
                            <label for="ore">Durata dell'evento:</label><br>
                            <input type="number" name="ore" id="ore" max="24" placeholder="Ore" style="width: 142px;">&nbsp;&nbsp;:&nbsp;&nbsp;
                            <input type="number" name="minuti" id="minuti" max="59" placeholder="Minuti" style="width: 142px;" required>
                        </p>
                        <p>
                            <input type="hidden" name="organizzatore" value="<?php echo $nome_societa; ?>" required>
                        <!-- Luogo evento -->
                        <div class="input-container">
                            <div class="autocomplete" style="width: 300px;">
                                <input
                                    type="text"
                                    id="luogo"
                                    name="luogo"
                                    value=""
                                    aria-labelledby="label-luogo"
                                    oninput="manageTextInputStyle('luogo')"
                                    required
                                />
                                <label class="label" for="luogo" id="label-luogo">
                                    <div class="text">Luogo</div>
                                </label>
                            </div>
                        </div>
                            
                        </p>
                        <p>
                        <!-- Tipo evento -->
                        <div class="input-container">
                            <div class="autocomplete" style="width: 300px;">
                                <input
                                    type="text"
                                    id="tipo"
                                    name="tipo"
                                    value=""
                                    aria-labelledby="label-tipo"
                                    oninput="manageTextInputStyle('tipo')"
                                    required
                                />
                                <label class="label" for="tipo" id="label-tipo">
                                    <div class="text">Tipo di evento</div>
                                </label>
                            </div>
                        </div>
                        </p>
                        <p>
                        <!-- Link prenotazioni evento -->
                        <div class="input-container">
                            <input
                                type="url"
                                id="link_prenotazione"
                                name="link_prenotazione"
                                onfocus="document.getElementById('link_prenotazione').value = 'https:\/\/'; manageTextInputStyle('link_prenotazione')"
                                value=""
                                aria-labelledby="label-link_prenotazione"
                                oninput="manageTextInputStyle('link_prenotazione')"
                                onchange="manageTextInputStyle('link_prenotazione')"
                            />
                            <label class="label" for="link_prenotazione" id="label-link_prenotazione">
                                <div class="text">Link per prenotarsi (facoltativo)</div>
                            </label>
                        </div>
                        </p>
                    </div>
                    <div class="right_content">
                        <!-- Area di upload della locandina -->
                        <div class="drop-zone">
                            <span class="drop-zone__prompt">Trascina qui il file o clicca per caricarlo<br><br>
                            <a class="drop-zone__prompt__accepted_filetype"><b>File accettati:</b> .jpg, .jpeg, .png, .gif, .svg</a></span>
                            <input name="locandina" id="selectfile" class="drop-zone__input" type="file" accept=".jpg, .jpeg, .png, .gif, .svg">
                        </div>
                        <a onclick="openCanva()" title="Crea una locandina con Canva" class="canvaBtn">Crea una locandina con 
                        <img alt="Canva" src="https://static-cse.canva.com/_next/static/assets/logo_w2000xh641_3b021976d60d0277e95febf805ad9fe8c7d6d54f86969ec03b83299084b7cb93.png" height="16"></a>
                        <div class="material-icons" onclick="openHelp(true)" title="Apri istruzioni" style="cursor: pointer; position: relative; top: 30px; left: 20px;">help_outline</div>
                    </div>
                </div>
                <p>
                    <input type="submit" name="submit" value="Crea evento">
                    <input type="reset" value="Annulla" onclick="history.back();">
                </p>
            </form>
        </div>

        <!-- Finestra di aiuto per il pulsante "Crea una locandina con Canva" -->
        <div id="canvaHelp" style="display: none;">
            <a onclick="openHelp(false)" style="font-size: 25px; float: right; color: black; cursor: pointer; user-select: none;" title="Chiudi">&times;</a>
            <p><b>Come creare una locandina con Canva?</b></p>
            <ol>
                <li>Clicca sul pulsante "<a href="#" onclick="openCanva()">Crea una locandina con Canva</a>";</li>
                <li>Realizza la tua locandina nella finestra che si &egrave; aperta;</li>
                <li>Una volta finito, clicca sul pulsante "Condividi", in alto a destra;</li>
                <li>Nel menu che si apre, seleziona "Scarica";</li>
                <img src="../img/help/canva-fase-1-e-2.png">
                <li>In questo modo si apre un altro menu, dove basta cliccare sul pulsante viola "Scarica";</li>
                <img src="../img/help/canva-fase-3.png">
                <li>Fatto ci&ograve; potrebbe comparire una finestra che chiede di iscriversi a Canva: la possiamo anche chiudere. Una volta terminato il download, compare in basso il file appena scaricato (<b>N.B.:</b> ricordiamoci il nome del file, perch&eacute; dopo ci servir&agrave;);</li>
                <img src="../img/help/canva-fase-3b.png">
                <li>Ora &egrave; possibile chiudere l'inera finestra di Canva facendo clic sulla &times; in alto;</li>
                <img src="../img/help/canva-fase-4.png">
                <li>Tornati sul planner, clicchiamo nell'area di caricamento dei file;</li>
                <img src="../img/help/canva-fase-5.png">
                <li>Si apre la finestra per selezionare il file da caricare. Nella barra laterale a sinistra, clicchiamo sulla cartella "Download". Poi selezioniamo il file che avevamo scaricato prima e facciamo clic sul pulsante "Apri";</li>
                <img src="../img/help/canva-fase-6.png">
                <li>Ora, nell'area di caricamento dei file &egrave; presente la nostra locandina. Se abbiamo sbagliato file, possiamo cliccarci nuovamente sopra e ripetere i passaggi dal punto 8.</li>
            </ol>
        </div>

        <script>
        function manageTextInputStyle(id) {
            const input = document.getElementById(id);
            input.setAttribute('value', input.value);
        }

        function openCanva(e) {
            window.open("https://www.canva.com/design?create&type=TACixUyoqp0&category=tAFBBALx6F8&schema=web-2", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=1600,height=1000");
        }

        function openHelp(request) {
            if (request) {
                document.getElementById("canvaHelp").style.display = "block";
                document.body.style.overflow = "hidden";
            } else {
                document.getElementById("canvaHelp").style.display = "none";
                document.body.style.overflow = "auto";
            }
        }
        </script>
        <script>
        function autocomplete(inp, arr) {
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
                }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
                }
            }
        });
        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
            }
        }
        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function (e) {
            closeAllLists(e.target);
        });
        }

        /*An array containing all the country names in the world:*/
        var luoghi = ["Mercato coperto","Centro sociale","Sala polivalente","Piazza della Libertà","Piazza della Repubblica","Piazza Giuseppe Garibaldi","Piazza Vittorio Veneto","Crispo","Piazzetta A. Ragazzi","Area di sosta per camper - via Argine Po","Kayak Club","Palestra comunale di Castelmassa","Scuola primaria di I grado \"E. Panzacchi\"","Scuola secondaria di I grado \"G. Sani\"","Centro giovanile pastorale di Castelmassa","Scuola secondaria di II grado \"B. Munari\"","Teatro Cotogni","Sede A.V.P.","Black Coffee Arena (parcheggio bar Nerocaffè)","Piscine di Castelmassa","Sede BIG RIVER MOTOCLUB","Biblioteca comunale \"E. Fornasari\""];
        var tipi = ["Lezione","Spettaccolo","Fiera","Mostra","Incontro informativo","Partita","Festa","Pranzo","Cena","Maratona","Evento sportivo","Riunione","Evento"];

        /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
        autocomplete(document.getElementById("luogo"), luoghi);
        autocomplete(document.getElementById("tipo"), tipi);
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script>
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
        <?php
        } else {
            echo "<script type=\"text/javascript\">history.back();</script>";
        }
        ?>

        <br><br><br><br>
        <footer id="footer">
        <div class="footer-container">
            <div class="footer-row">
            <div class="footer-col">
                Realizzato da Albertin Emanuele e Paun Catalin-Adrian per conto di<br>
                <img alt="Logo I.I.S PRIMO LEVI di Badia Polesine" src="../img/logo_primo_levi.png" height="80">
            </div>
            <div class="footer-col">
                Progetto "Comunità inclusiva ed accogliente" in collaborazione con <img src="../img/logo_uni_pop.png" height="100" alt="Logo dell'Università Popolare del Tempo Libero di Castelmassa, Castelnovo Bariano, Ceneselli, Calto" title="Università Popolare del Tempo Libero di Castelmassa, Castelnovo Bariano, Ceneselli, Calto">
                <img alt="Logo Comune di Castelmassa" src="../img/logo_com_cast.png" height="80">
            </div>
            </div>
            <p class="copyright">A. P. Planner - ver. <?php echo $version; ?></p>
        </div>
        </footer>

        <script>
             document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("#footer").style.opacity = 1;
            });
        </script>
    </body>
</html>
