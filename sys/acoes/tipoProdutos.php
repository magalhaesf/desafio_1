<?php
    require_once('../../class/conexao.class.php');
    $obConexao = new conexao();
    $Produtos = $obConexao->recuperaTipoProdutos();

    echo $Produtos;
?>