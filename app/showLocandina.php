<?php
$link_foto_video = $_GET['url'];

$url = "../evento/locandine/".$link_foto_video;
?>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="../css/default_phone.css" type="text/css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0">
<img src="<?php echo $url; ?>" alt="Locandina" style="width: 100%; margin-top: 90px;">
