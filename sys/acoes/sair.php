<?php
require_once('sessao.php');
if(isset($_SESSION['cpf'])){
    echo 'sair';
    session_destroy();
}
?>