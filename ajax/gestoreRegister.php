<?php
    require_once "../class/Database.php";

    if(!isset($_GET["username"], $_GET["password"], $_GET["email"])) {
        $ret = [];
        $ret["status"] = "ERR";
        $ret["msg"] = "Parametri mancanti!";
        echo json_encode($ret);
        die();
    }

    $username = $_GET["username"];
    $password = md5($_GET["password"]);
    $email = $_GET["email"];
    $db = Database::getInstance();
    $idUtente = $db->doRegister($username, $password, $email);

    if($idUtente == null) {
        $ret = [];
        $ret["status"] = "ERR";
        $ret["msg"] = "Errore durante la registrazione!";
        echo json_encode($ret);
        die();
    }else {
        if(!isset($_SESSION))
            session_start();
        $_SESSION["user"] = $idUtente;

        $ret = [];
        $ret["status"] = "OK";
        $ret["msg"] = "";
        echo json_encode($ret);
        die();
    }
?>