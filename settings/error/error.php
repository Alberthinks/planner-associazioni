<?php
$error = $_GET['status'];

switch ($error) {
    case "err5801x24-License-Key":
        $title = "License Key mancante o scaduta";
        $content = "Sembra che la License Key non sia presente o la licenza sia scaduta, quindi la piattaforma &egrave; stata disabilitata temporaneamente.<br>
        Per risolvere il problema, contatta l'amministratore.";
        $graphics = "<img src=\"https://img.icons8.com/color/160/null/no-entry--v1.png\" draggable=\"false\"/>";
        break;
    case "err5077x26-Maintenance":
        $title = "Manutenzione in corso";
        $content = "La piattaforma &egrave; attualmente in manutenzione per migliorare alcune caratteristiche o per aggiungere nuove funzionalit&agrave;.<p>I nostri tecnici altamente specializzati stanno lavorando freneticamente per mantenere il servizio costantemente aggiornato.</p>Prova a tornare qui pi&ugrave; tardi.<p style='margin-bottom: 60px;'>Se il problema persiste, contatta l'amministratore.</p>";
        $graphics = '<svg viewBox="0 0 490 525" style="width: 200px; float: right;"><path fill="#6A1B9A" d="M325 85c1 12-1 25-5 38-8 29-31 52-60 61-26 8-54 14-81 18-37 6-26-37-38-72l-4-4c0-17-9-33 4-37l33-4c9-2 9-21 11-30 1-7 3-14 5-21 8-28 40-42 68-29 18 9 36 19 50 32 13 11 16 31 17 48z"></path><path fill="none" stroke="#6A1B9A" stroke-width="24" stroke-linecap="round" stroke-miterlimit="10" d="M431 232c3 15 21 19 34 11 15-9 14-30 5-43-12-17-38-25-59-10-23 18-27 53-21 97s1 92-63 108"></path><path fill="#6A1B9A" d="M284 158c35 40 63 85 86 133 24 52-6 113-62 123-2 0-4 1-6 1-53 9-101-33-101-87V188l83-30z"></path><path fill="#F7CB4D" d="M95 152c-3-24 13-57 46-64l27-5c9-2 16-19 17-28l3-15 20-3c44 14 42 55 18 69 22 0 39 26 32 53-5 18-20 32-39 36-13 3-26 5-40 8-50 8-80-14-84-51z"></path><path fill="#6A1B9A" d="M367 392c-21 18-77 70-25 119h-61c-27-29-32-69 1-111l85-8z"></path><path fill="#6A1B9A" d="M289 399c-21 18-84 62-32 111h-61c-37-34-5-104 43-134l50 23z"></path><path fill="#EDB526" d="M185 56l3-15 20-3c25 8 35 25 35 41-12-18-49-29-58-23z"></path><path fill="#E62117" d="M190 34c8-28 40-42 68-29 18 9 36 19 50 32 10 9 14 23 16 37L187 46l3-12z"></path><path fill="#8E24AA" d="M292 168c0 0 0 201 0 241s20 98 91 85l-16-54c-22 12-31-17-31-37 0-20 0-108 0-137S325 200 292 168z"></path><path fill="#F7CB4D" d="M284 79c11-9 23-17 35-23 25-12 54 7 59 38v1c4 27-13 51-36 53-12 1-25 1-37 0-22-1-39-27-32-52v-1c2-6 6-12 11-16z"></path><path fill="#6A1B9A" d="M201 203s0 84-95 140l22 42s67-25 89-86-16-96-16-96z"></path><path fill="#BE2117" d="M224 54l-67-14c-10-2-13-15-5-21s18-6 26 0l46 35z"></path><circle fill="#4A148C" cx="129" cy="161" r="12"></circle><circle fill="#4A148C" cx="212" cy="83" r="7"></circle><circle fill="#4A148C" cx="189" cy="79" r="7"></circle><path fill="#F7CB4D" d="M383 493c11-3 19-8 25-13 7-10 4-16-5-20 8-9 2-22-8-18 1-1 1-2 1-3 3-9-9-15-15-8-3 4-8 7-13 9l15 53z"></path><path fill="#EDB526" d="M252 510c5 6 0 15-9 15h-87c-10 0-16-8-13-15 5-12 21-19 36-16l73 16z"></path><ellipse transform="rotate(19.126 278.35 14.787)" fill="#E62117" cx="278" cy="15" rx="9" ry="7"></ellipse><path fill="#F7CB4D" d="M341 510c5 6 0 15-9 15h-87c-10 0-16-8-13-15 5-12 21-19 36-16l73 16z"></path><path fill="#EDB526" d="M357 90c-12-19-35-23-55-11-19 12-25 32-13 52"></path><path fill="#E62117" d="M110 427l21-9c5-2 7-8 5-13l-42-94c-3-6-9-9-15-6l-11 5c-6 2-9 9-7 15l36 97c2 5 8 7 13 5z"></path><path fill="#B0BEC5" d="M37 278l41-17c11-4 22-5 33-1 5 2 10 4 14 6 6 3 4 11-3 11-9 0-18 1-26 3l2 12c1 6-2 11-8 13l-36 15c-5 2-10 1-14-2l-9-7-2 17c0 2-2 4-4 5l-3 1c-3 1-7 0-8-3L1 300c-1-3 0-7 4-9l4-2c2-1 5 0 7 1l12 10 1-11c0-5 3-9 8-11z"></path><path fill="#F7CB4D" d="M103 373c10 2 14 10 8 19 6-1 10 4 10 9 0 3-3 6-6 7l-26 11c-2 1-5 1-8 0-6-3-7-9-2-16-7-1-13-9-6-17-8-1-12-8-8-15l3-3 23-11c9-4 19 8 12 16z"></path><ellipse transform="rotate(173.3 233.455 334.51)" fill="#8E24AA" cx="234" cy="335" rx="32" ry="46"></ellipse></svg>
        <i class="fa fa-sharp spin fa-solid fa-gear fa-5x" style="float: right;"></i>';
        break;
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Icone -->
        <link rel="apple-touch-icon" sizes="180x180" href="../../img/icon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../../img/icon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../../img/icon/favicon-16x16.png">
        <link rel="manifest" href="../../img/icon/site.webmanifest">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!-- Titolo -->
        <title><?php echo $title; ?></title>
        <style>
            * {font-family: 'Open Sans', sans-serif;}
            p {font-size: 18px; font-weight: 400;}
            h1 {font-weight: 800;}
            a.btn {text-decoration: none; font-family: 'Arial', sans-serif; margin-top: 20px; font-size: 18px; color: #24d3b5; border: 1.2px solid #24d3b5; padding: 10px 20px 10px 20px; border-radius: 5px; transition: 0.4s;}
            a.btn:hover {background-color: #24d3b5; color: white;}
            .spin {animation: spin 6s infinite linear;}
            @keyframes spin {
                from {transform: rotate(0deg);}
                to {transform: rotate(359deg);}
            }

            .info {position: fixed; bottom: 20px; right: 20px; cursor: pointer; user-select: none;}
            #credits {position: fixed; right: 30px; bottom: 60px; color: black; background-color: rgba(255, 255, 255, 0.8); padding: 10px; width: 350px; border-radius: 6px; box-shadow: 0 0 8px #eee;} 
            #credits a {color: black; text-decoration: underline !important;}
        </style>
    </head>
    <body>
        <div style="float: right;"><?php echo $graphics; ?></div>
        <h1><?php echo $title; ?></h1>
        <p><?php echo $content; ?></p>
        <a href="../../" class="btn">Riprova</a>

        <?php
        echo '<a class="material-icons info" onclick="toggleDisplay()">info</a>';
        echo '<div id="credits" style="display: none;">';
        echo '<a target="_blank" href="https://icons8.com/icon/63656/no-entry">No Entry icon by Icons8</a><br>';
        echo '</div>';
        echo '<script>function toggleDisplay() {if(document.getElementById("credits").style.display == "none"){document.getElementById("credits").style.display = "block"} else {document.getElementById("credits").style.display = "none"}}</script>';
        ?>
        <script>
            setInterval(function() {location.replace("../../");}, 60000);
        </script>
    </body>
</html>
