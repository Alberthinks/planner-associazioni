<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Attenzione!</title>
        <style>
            div {
            margin-bottom: 15px;
            padding: 4px 12px;
            font-family: 'Open Sans', sans-serif;
            }

            .danger {
            background-color: #ffdddd;
            border-left: 6px solid #f44336;
            }
        </style>
    </head>
    <body>
        <div class="danger">
            <p><strong>Attenzione!
                <?php
                    include "../default.php";
                    
                    session_start();
                    $config = [
                        'db_engine' => 'mysql',
                        'db_host' => 'localhost',
                        'db_name' => 'users',
                        'db_user' => 'root',
                        'db_password' => 'mysql',
                    ];
                    
                    $db_config = $config['db_engine'] . ":host=".$config['db_host'] . ";dbname=" . $config['db_name'];
                    
                    try {
                        $pdo = new PDO($db_config, $config['db_user'], $config['db_password'], [
                            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                        ]);
                            
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    } catch (PDOException $e) {
                        echo "<script>location.replace('index.php?error=0x85ar6q');</script>";
                        exit("Impossibile connettersi al database: " . $e->getMessage());
                    }

                    $username = cripta($_POST['username'], "encrypt") ?? '';
                    $password = $_POST['password'] ?? '';
                    
                    if (empty($username) || empty($password)) {
                        $msg = 'Inserisci username e password %s';
                    } else {
                        $query = "
                            SELECT *
                            FROM users
                            WHERE username = :username
                        ";
                        
                        $check = $pdo->prepare($query);
                        $check->bindParam(':username', $username, PDO::PARAM_STR);
                        $check->execute();
                        
                        $user = $check->fetch(PDO::FETCH_ASSOC);
                        
                        if (!$user || password_verify($password, $user['password']) === false) {
                            $msg = 'Credenziali utente errate %s';
                            echo "<script>location.replace('index.php?error=0x5d66e0');</script>";
                        } else {
                            
                            // Togliere/aggiungere in base ai record del database specifico
                            date_default_timezone_set("Europe/Rome");
                            //$now = date("d F Y H:i:sa", time());

                            session_regenerate_id();
                            $_SESSION['session_id_lele_planner_0425'] = session_id();
                            $_SESSION['session_user_lele_planner_0425'] = cripta($user['username'], "decrypt");
                            $_SESSION['session_ao_lele_planner_0425'] = cripta($user['ao'], "decrypt");
                            $_SESSION['session_nome_lele_planner_0425'] = cripta($user['nome'], "decrypt");
                            $_SESSION['session_cognome_lele_planner_0425'] = cripta($user['cognome'], "decrypt");
                            $_SESSION['session_logo_lele_planner_0425'] = cripta($user['logo'], "decrypt");
                            $_SESSION['session_nome-societa_lele_planner_0425'] = cripta($user['nome_societa'], "decrypt");

                            $timestampNumber = date('d/m/Y H:i:s', strtotime("now"));
                            $usernme = $user['username'];

                            $sql = "UPDATE users SET last_access='$timestampNumber' WHERE username = '$usernme'";
                            $conn = mysqli_connect($config['db_host'],$config['db_user'],$config['db_password'], $config['db_name']) or die (mysqli_error());

                            $myconn = mysqli_connect($config['db_host'],$config['db_user'],$config['db_password'], 'accesses') or die (mysqli_error());
                            $timestamp = cripta($timestampNumber, "encrypt");
                            $action = cripta("Accesso all'account", "encrypt");
                            $ip = cripta($_SERVER['REMOTE_ADDR'], "encrypt");
                            $mysql = "INSERT INTO accesses (username,nome,cognome,nome_societa,ip,azione,timestamp,validity) VALUES ('$user[username]', '$user[nome]','$user[cognome]','$user[nome_societa]','$ip','$action','$timestamp','$dataValidity')";
            
                            if(mysqli_query($conn,$sql) or die (mysqli_error($conn))) {
                                if($result = mysqli_query($myconn,$mysql) or die (mysqli_error($conn))) {
                                    header('Location: ../');
                                }
                                exit;
                              } else {
                                echo "Errore: " . $sql . "<br>" . $conn->error;
                              }
                        }
                    }
                    
                    printf($msg, '<a href="javascript:window.history.back()">torna indietro</a>');
                ?>
            </p>
        </div>
    </body>
</html>
