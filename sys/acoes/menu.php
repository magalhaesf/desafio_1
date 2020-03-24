<?php
    session_start();
    require_once('../../class/conexao.class.php');

    $obConexao = new conexao();
    $arMenu = $obConexao->recuperaMenu();

    echo $arMenu;
?>