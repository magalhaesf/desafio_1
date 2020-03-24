<?php
    foreach($_POST as $k => $d) {
        $$k = $d;
    }

    require_once('../../class/conexao.class.php');
    $obConexao = new conexao();

    if ($acao == 'incluir') {
        switch ($codigo) {
            case 1:
                if (trim($descricao) == '' OR trim($abreviacao) == '') {
                    echo 0;
                    die;
                } else {
                    $obConexao->inserirUnidade($descricao, $abreviacao);
                }
            break;
            case 2:
                if (trim($descricao) == '' OR trim($imposto) == '') {
                    echo 0;
                    die;
                } else {
                    $obConexao->inserirTipoProdutos($descricao, $imposto);
                }
            break;
            case 3:
                if (trim($descricao) == '' OR trim($valor) == '' OR trim($id_tipo_produtos) == '' OR trim($id_unidades) == '') {
                    echo 0;
                    die;
                } else {
                    $obConexao->inserirProdutos($descricao, $valor, $id_tipo_produtos, $id_unidades);
                }
            break;
            case 4:
                $obConexao->inserirVendas($tabela, $valorTotal, $impostoTotal, $impostoPagoTotal);
            break;
        }
    } elseif ($acao == 'alterar') {
        switch ($codigo) {
            case 1:
                if (trim($descricao) == '' OR trim($abreviacao) == '' OR trim($cod_unidade) == '') {
                    echo 0;
                    die;
                } else {
                    $obConexao->atualizarUnidade($cod_unidade, $descricao, $abreviacao);
                }
            break;
            case 2:
                if (trim($descricao) == '' OR trim($imposto) == '' OR trim($cod_tipo_produtos) == '') {
                    echo 0;
                    die;
                } else {
                    $obConexao->atualizarTipoProdutos($cod_tipo_produtos, $descricao, $imposto);
                }
            break;
            case 3:
                if (trim($descricao) == '' OR trim($valor) == '' OR trim($id_tipo_produtos) == '' OR trim($id_unidades) == '') {
                    echo 0;
                    die;
                } else {
                    $obConexao->atualizarProdutos($cod_produto, $descricao, $valor, $id_tipo_produtos, $id_unidades);
                }
            break;
        }
    }
    
?>