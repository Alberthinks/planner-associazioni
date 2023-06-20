<?php
require_once('Facebook/facebook.php');
$appId     = "MY_APP_ID";
$appSecret = "MY_APP_SECRET";
 
// inizializzo la sessione 
$facebook = new Facebook( array(
    'appId'  => $appId,
    'secret' => $appSecret,
    'cookie' => true
) );

// ottengo l'utente corrente 
$user = $facebook->getUser();
 
// ottengo l'URL di login 
$loginUrl = $facebook->getLoginUrl( array(
    'scope' => 'manage_pages, publish_actions'
) );
 
if ( ! isset( $_REQUEST['code'] ) ) {
    header( "Location: " . $loginUrl );
} 

// Token di accesso breve
$shortLiveToken = "";
 
if ( $user ) {
    // ho già un utente loggato, memorizzo il suo token
    $shortLiveToken = $facebook->getAccessToken();
} else {
    // richiedo il token di breve periodo con i permessi desiderati
    $code        = $_REQUEST['code'];
    $redirectUrl = $_SERVER['REQUEST_URI'];
    $result      = file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=$appId&client_secret=$appSecret&code=$code&redirect_uri=$redirectUrl&scope=manage_pages,publish_actions");
     
    if ( substr( $result, 0, 13 ) != "access_token=" ) {
        exit();
    }
     
    $endPos = strpos( $result, "&expire" );
     
    if ( ! ( $endPos === false ) ) {
        $endPos -= 13;
    } else {
        $endPos = strlen( $result );
    }
     
    $shortLiveToken = substr( $result, 13, $endPos );
}

// chiedo un token di lunga durata a partire da quello di breve durata 
$params = array(
    'grant_type'        => 'fb_exchange_token',
    'client_id'         => $appId,
    'client_secret'     => $appSecret,
    'fb_exchange_token' => $shortLiveToken
);
 
$url = "https://graph.facebook.com/oauth/access_token";
$ch  = curl_init();
curl_setopt_array( $ch, array(
    CURLOPT_URL            => $url,
    CURLOPT_POSTFIELDS     => $params,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_VERBOSE        => true
) );
 
// invio la richiesta a Facebook 
$result = curl_exec( $ch );
 
if ( substr( $result, 0, 13 ) != "access_token=" ) {
    exit();
}
 
$endPos = strpos( $result, "&expire" );
 
if ( ! ( $endPos === false ) ) {
    $endPos -= 13;
} else {
    $endPos = strlen( $result );
}
 
$longLiveToken = substr( $result, 13, $endPos ); 

// ora ottengo le pagine su cui l'utente ha poteri amministrativi
$url    = "https://graph.facebook.com/me/accounts?access_token=$longLiveToken";
$result = file_get_contents( $url );
 
// decodifico la risposta JSON
$objPagine = json_decode( $result, true );
 
// leggo il primo oggetto
$data = $objPagine['data'];
 
$accessToken = "";
 
// cerco la mia pagina
for ( $i = 0; $i < count( $data ); $i ++ ) {
    $page = $data[ $i ];
 
    if ( $page['name'] == "MIA PAGINA" ) {
        $accessToken = $page['access_token'];
        $pageId      = $page['id'];
        break;
    }
}
 
if ( $accessToken == "" ) {
    exit();
}
 
echo $accessToken;

?>