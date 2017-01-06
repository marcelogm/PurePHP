<?php
namespace App\View\Pages;
use App\Util\DynamicHtml;
?>

<?php DynamicHtml::error_message(isset($message) ? $message : null); ?>
<div class="container-fluid custom-background">
    <div class="container">
        <div class="col-md-offset-3 col-md-6 custom-login-form custom-inverse">
            <form action="<?= DynamicHtml::link_to('site/registration') ?>" method="POST" role="form">
                <center>
                    <legend>
                        <h3>
                            <div class="custom-text-logo">Teller </div>
                            <small>A melhor opção para suas economias.</small>
                        </h3>
                    </legend>
                    <div class="form-group">
                        <div class="input-group custom-input-group">
                            <span class="input-group-addon">Nome: </span>
                            <input type="text" class="form-control" name="nome" placeholder="João da Silva" required/>
                        </div>
                        <div class="input-group custom-input-group">
                            <span class="input-group-addon">Email: </span>
                            <input type="email" class="form-control" name="email" placeholder="exemplo@teller.com" required/>
                        </div>
                        <div class="input-group custom-input-group">
                            <span class="input-group-addon">Senha: </span>
                            <input type="password" class="form-control" name="password" placeholder="*****************" required/>
                        </div>
                        <div class="input-group custom-input-group">
                            <span class="input-group-addon">Confirme: </span>
                            <input type="password" class="form-control" name="repassword" placeholder="Digite a senha novamente" required/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg custom-btn custom-btn-color">Registrar</button>
                </center>
            </form>
        </div>
    </div>
</div>