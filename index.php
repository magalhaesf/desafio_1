<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Desafio</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">

    <script src="vendor/jquery/jq.js"></script>
    <script src="vendor/popper/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/mask/jquery.mask.js"></script>
    <script src="javascript.js"></script>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Entrar</h3>
                    <div class="d-flex justify-content-end social_icon">
                        <span><i class="fa fa-cart-plus"></i></span>
                    </div>
                </div>
                <div class="card-body">
                    <form id='frmLogin' method="POST" action="">
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">CPF</span>
                            </div>
                            <input type="text" class="form-control" placeholder="CPF" name="cpf" id="cpf" maxlength="14">
                            
                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Senha</span>
                            </div>
                            <input type="password" class="form-control" placeholder="senha" name="senha" id="senha">
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn float-right login_btn">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>