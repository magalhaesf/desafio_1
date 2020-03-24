<?php
    foreach($_POST as $k => $d) {
        $$k = $d;
    }

    require_once('../../class/conexao.class.php');
    $obConexao = new conexao();

    switch ($codigo) {
        case 1:
            $obConexao->consultarUnidade($cod_registro);
        break;
        case 2:
            $obConexao->consultarTipoProdutos($cod_registro);
        break;
        case 3:
            $obConexao->consultarProdutos($cod_registro);
        break;
        case 4:
            // $obConexao->inserirVendas();
        break;
    }
?>