<?php
    require_once('../../class/conexao.class.php');
    $obConexao = new conexao();
    $unidades = $obConexao->recuperaUnidades();

    echo $unidades;
?>