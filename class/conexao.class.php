<?php 

Class conexao {
    private $user = 'postgres';
    private $senha = '123';
    private $host = 'localhost';
    private $database = 'desafio';
    private $port = '5432';
    protected $conex = NULL;

    public function __construct() {

    }

    protected function abreConexao() {
        try {
            $this->conex = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->database;user=$this->user;password=$this->senha");
            return $this->conex;
        } catch (PDOException $e) {
            header('Location: ../index.php');
        }
    }
    
    public function recuperaLogin($cpf, $pass) {
        $this->abreConexao();
        $stSQL = "SELECT * 
                    FROM user_sys 
                   WHERE cpf = $cpf 
                         AND senha = '$pass';";
        
        $resultado = $this->conex->query($stSQL);
        $arResultado = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($arResultado !== FALSE) {
            session_start();
            $_SESSION['cpf'] = $arResultado['cpf'];
            $_SESSION['nome'] = $arResultado['nome'];
            
            return 1;
        } else {
            return 0;
        }
    }

    public function recuperaMenu() {
        if (isset($_SESSION['cpf'])) {
            $this->abreConexao();
            $stSQL = "SELECT sys.descricao
                            , sys.caminho 
                            , sys.id
                        FROM tipo_user_sys 
                        JOIN tipo_user 
                        ON tipo_user_sys.id_tipo_user = tipo_user.id
                        JOIN user_sys
                        ON tipo_user.id = user_sys.id_tipo_user
                        JOIN sys
                        ON tipo_user_sys.id_sys = sys.id
                    WHERE cpf = ".$_SESSION['cpf'];

            $resultado = $this->conex->query($stSQL);
            $arResultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

            if ($arResultado !== FALSE) {
                foreach ($arResultado as $d) {
                    $stHtml = "<button type='button' class='btn btn-menu btn-lg btn-block' data-caminho='".$d["caminho"]."' value='#".$d['id']."'>".$d["descricao"]."</button>";
                    echo $stHtml;
                }
                    echo "<button type='button' class='btn btn-menu btn-lg btn-block' id='btn-sair'>Sair</button>";
            } else {
                return $arResultado = array();
            }
        } else {
            echo 'sair';
        }
    }

    public function recuperaUnidades() {
        $this->abreConexao();
        $stSQL = "SELECT *
                    FROM unidades";

        $resultado = $this->conex->query($stSQL);
        $arResultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

        if ($arResultado !== FALSE) {
            $stString = '{"data":[';
            foreach($arResultado as $d) {
                $stString .= '["'.$d['id'].'","'.$d['descricao'].'","'.$d['abreviacao'].'"],';
            }
            $stString = RTRIM($stString, ',');
            $stString .= ']}';
            return $stString;
        } else {
            $arResultado = array();
            return json_encode($arResultado);
        }
    }

    public function inserirUnidade($descricao, $abreviacao) {
        $this->abreConexao();
        $stSQL = "INSERT INTO unidades (descricao, abreviacao) VALUES (:descricao, :abreviacao);";

        $stmt = $this->conex->prepare($stSQL);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':abreviacao', $abreviacao, PDO::PARAM_STR);

        $resultado = $stmt->execute();

        if (!$resultado) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function consultarUnidade($cod_unidade) {
        $this->abreConexao();
        $stSQL = "SELECT id
                         , descricao
                         , abreviacao 
                    FROM unidades 
                   WHERE id = ".$cod_unidade;

        $resultado = $this->conex->query($stSQL);
        $arResultado = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($arResultado !== FALSE) {
            echo $arResultado['id'].'#'.$arResultado['descricao'].'#'.$arResultado['abreviacao'];
        } else {
            echo '';
        }
    }

    public function atualizarUnidade ($cod_unidade, $descricao, $abreviacao) {
        $this->abreConexao();
        $stSQL = "UPDATE unidades SET descricao = :descricao, abreviacao = :abreviacao WHERE id = :id;";

        $stmt = $this->conex->prepare($stSQL);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':abreviacao', $abreviacao, PDO::PARAM_STR);
        $stmt->bindParam(':id', $cod_unidade, PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if (!$resultado) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function recuperaTipoProdutos() {
        $this->abreConexao();
        $stSQL = "SELECT *
                    FROM tipo_produtos";

        $resultado = $this->conex->query($stSQL);
        $arResultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

        if ($arResultado !== FALSE) {
            $stString = '{"data":[';
            foreach($arResultado as $d) {
                $stString .= '["'.$d['id'].'","'.$d['descricao'].'","'.str_replace('.', ',', $d['imposto']).'%"],';
            }
            $stString = RTRIM($stString, ',');
            $stString .= ']}';
            return $stString;
        } else {
            $arResultado = array();
            return json_encode($arResultado);
        }
    }

    public function consultarTipoProdutos($cod_tipo_produto) {
        $this->abreConexao();
        $stSQL = "SELECT id
                         , descricao
                         , imposto 
                    FROM tipo_produtos 
                   WHERE id = ".$cod_tipo_produto;

        $resultado = $this->conex->query($stSQL);
        $arResultado = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($arResultado !== FALSE) {
            echo $arResultado['id'].'#'.$arResultado['descricao'].'#'.str_replace('.', ',', $arResultado['imposto']);
        } else {
            echo '';
        }
    }

    public function inserirTipoProdutos($descricao, $imposto) {
        $imposto = str_replace(',', '.', $imposto);
        
        $this->abreConexao();
        $stSQL = "INSERT INTO tipo_produtos (descricao, imposto) VALUES (:descricao, :imposto);";

        $stmt = $this->conex->prepare($stSQL);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':imposto', $imposto, PDO::PARAM_STR);

        $resultado = $stmt->execute();

        if (!$resultado) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function atualizarTipoProdutos ($cod_tipo_produto, $descricao, $imposto) {
        $imposto = str_replace(',', '.', $imposto);
        
        $this->abreConexao();
        $stSQL = "UPDATE tipo_produtos SET descricao = :descricao, imposto = :imposto WHERE id = :id;";

        $stmt = $this->conex->prepare($stSQL);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':imposto', $imposto, PDO::PARAM_STR);
        $stmt->bindParam(':id', $cod_tipo_produto, PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if (!$resultado) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function recuperaProdutos() {
        $this->abreConexao();
        $stSQL = "SELECT produtos.id
                         , produtos.descricao
                         , produtos.valor
                         , tipo_produtos.descricao AS descricao_tipo_produto
                         , unidades.descricao AS descricao_unidades
                         , produtos.id_tipo_produtos
                         , produtos.id_unidades
                    FROM produtos
                    JOIN tipo_produtos
                      ON produtos.id_tipo_produtos = tipo_produtos.id
                    JOIN unidades
                      ON produtos.id_unidades = unidades.id";

        $resultado = $this->conex->query($stSQL);
        $arResultado = $resultado->fetchAll(PDO::FETCH_ASSOC);

        if ($arResultado !== FALSE) {
            $stString = '{"data":[';
            foreach($arResultado as $d) {
                $stString .= '[
                               "'.$d['id'].'"
                              ,"'.$d['descricao'].'"
                              ,"R$ '.str_replace('.', ',', $d['valor']).'"
                              , "'.$d['descricao_tipo_produto'].'"
                              , "'.$d['descricao_unidades'].'"
                              , "'.$d['id_tipo_produtos'].'"
                              , "'.$d['id_unidades'].'"
                              ],';
            }
            $stString = RTRIM($stString, ',');
            $stString .= ']}';
            return $stString;
        } else {
            $arResultado = array();
            return json_encode($arResultado);
        }
    }

    public function inserirProdutos($descricao, $valor, $id_tipo_produtos, $id_unidades) {
        $valor = str_replace(',', '.', $valor);
        
        $this->abreConexao();
        $stSQL = "INSERT INTO produtos (descricao, valor, id_tipo_produtos, id_unidades) VALUES (:descricao, :valor, :id_tipo_produtos, :id_unidades);";

        $stmt = $this->conex->prepare($stSQL);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':id_tipo_produtos', $id_tipo_produtos, PDO::PARAM_INT);
        $stmt->bindParam(':id_unidades', $id_unidades, PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if (!$resultado) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function consultarProdutos($cod_produto) {
        $this->abreConexao();
        $stSQL = "SELECT produtos.id
                         , produtos.descricao
                         , produtos.valor
                         , produtos.id_tipo_produtos
                         , produtos.id_unidades
                         , tipo_produtos.descricao AS descricao_tipo_produto
                         , unidades.descricao AS descricao_unidade
                         , tipo_produtos.imposto
                         , unidades.abreviacao
                    FROM produtos
                    JOIN tipo_produtos
                      ON produtos.id_tipo_produtos = tipo_produtos.id
                    JOIN unidades
                      ON produtos.id_unidades = unidades.id
                   WHERE produtos.id = ".$cod_produto;

        $resultado = $this->conex->query($stSQL);
        $arResultado = $resultado->fetch(PDO::FETCH_ASSOC);

        if ($arResultado !== FALSE) {
            echo $arResultado['id'].'#'.$arResultado['descricao'].'#'.str_replace('.', ',', $arResultado['valor']).'#'.$arResultado['id_tipo_produtos'].'#'.$arResultado['id_unidades'].'#'.$arResultado['descricao_tipo_produto'].'#'.$arResultado['descricao_unidade'].'#'.$arResultado['imposto'].'#'.$arResultado['abreviacao'];
        } else {
            echo '';
        }
    }

    public function atualizarProdutos ($cod_produto, $descricao, $valor, $id_tipo_produtos, $id_unidades) {
        $valor = str_replace(',', '.', $valor);
        
        $this->abreConexao();
        $stSQL = "UPDATE produtos SET descricao = :descricao, valor = :valor, id_tipo_produtos = :id_tipo_produtos, id_unidades = :id_unidades WHERE id = :id;";

        $stmt = $this->conex->prepare($stSQL);
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindParam(':id_tipo_produtos', $id_tipo_produtos, PDO::PARAM_INT);
        $stmt->bindParam(':id_unidades', $id_unidades, PDO::PARAM_INT);
        $stmt->bindParam(':id', $cod_produto, PDO::PARAM_INT);

        $resultado = $stmt->execute();

        if (!$resultado) {
            echo 0;
        } else {
            echo 1;
        }
    }

    public function inserirVendas($tabela, $valorTotal, $impostoTotal, $impostoPagoTotal) {
        $valorTotal = str_replace(',', '.', $valorTotal);
        $impostoTotal = str_replace(',', '.', $impostoTotal);
        $impostoPagoTotal = str_replace(',', '.', $impostoPagoTotal);

        $this->abreConexao();
        $stSQL = "INSERT INTO vendas (valorTotal, impostoTotal, impostoTotalPago) VALUES (:valorTotal, :impostoTotal, :impostoPagoTotal) RETURNING id;";

        $stmt = $this->conex->prepare($stSQL);
        $stmt->bindParam(':valorTotal', $valorTotal, PDO::PARAM_STR);
        $stmt->bindParam(':impostoTotal', $impostoTotal, PDO::PARAM_STR);
        $stmt->bindParam(':impostoPagoTotal', $impostoPagoTotal, PDO::PARAM_STR);

        $resultado = $stmt->execute();

        if (!$resultado) {
            echo 0;
        } else {
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach ($tabela as $d) {
                $stSQL = "INSERT INTO vendas_produtos (id_produtos, id_vendas, valorproduto, imposto, quantidade) VALUES (:id_produtos, :id_vendas, :valorProduto, :imposto, :quantidade);";

                $temp2 = str_replace(',', '.', $d[3]);
                $temp3 = str_replace(',', '.', $d[4]);
                $temp4 = str_replace(',', '.', $d[2]);

                $stmt = $this->conex->prepare($stSQL);
                $stmt->bindParam(':id_produtos', $d[0], PDO::PARAM_INT);
                $stmt->bindParam(':id_vendas', $resultado['id'], PDO::PARAM_INT);
                $stmt->bindParam(':valorProduto', $temp2, PDO::PARAM_STR);
                $stmt->bindParam(':imposto', $temp3, PDO::PARAM_STR);
                $stmt->bindParam(':quantidade', $temp4, PDO::PARAM_STR);

                $result = $stmt->execute();
            }
            
            if (!$result) {
                echo 0;
            } else {
                echo 1;
            }
        }
    }
}
?>