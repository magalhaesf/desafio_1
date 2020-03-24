<?php
$cpf = str_replace(array('.', '-'), '',$_POST['cpf']);
$pass = $_POST['senha'];


require_once('class/conexao.class.php');
$obConexao = new Conexao();
$boLogin = $obConexao->recuperaLogin($cpf, $pass);

echo $boLogin;
?>