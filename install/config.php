<?php
$servername = "localhost";
$username = "lele_superuser";
$password = "9kQuc(F[D3G0!c9leeeeE41gr4r4gf5df55we38";
$dbname = "users";

function cripta($string, $method) {
    $secretKey = "fdgjgtn544h1th1gb1ff";
    $secretIv = "fg4g4g1t11gfcfss";

    $algorithm = "AES-256-CBC";
    $key = hash("sha256", $secretKey);
    $iv = substr(hash('sha256', $secretIv), 0, 16);

    if ($method == "encrypt") {
        $output = base64_encode(openssl_encrypt($string, $algorithm, $key, 0, $iv));
    }

    if ($method == "decrypt") {
        $output = stripslashes(openssl_decrypt(base64_decode($string), $algorithm, $key, 0, $iv));
    }

    return $output;
}

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>