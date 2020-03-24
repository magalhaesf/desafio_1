<?php
    require_once('../../class/conexao.class.php');
    $obConexao = new conexao();
    $Produtos = $obConexao->recuperaProdutos();

    echo $Produtos;
?>