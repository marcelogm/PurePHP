<?php
namespace App\View\Pages;
use App\Util\DynamicHtml;
?>

<?php DynamicHtml::error_message(isset($message) ? $message : null); ?>
<?php DynamicHtml::feedback_message(isset($feedback) ? $feedback : null); ?>
<div class="container-fluid custom-background">
    <div class="container">
        <div class="col-md-offset-4 col-md-4 custom-login-form custom-inverse">
            <center>
                <form action="<?= DynamicHtml::link_to('site/login') ?>" method="POST">
                    <legend>
                        <h2>
                            <div class="custom-text-logo">Teller </div>
                            <small>Rápido, simples e útil.</small>
                        </h2>
                    </legend>
                    <div class="form-group">
                        <div class="input-group custom-input-group">
                            <span class="input-group-addon">Email: </span>
                            <input type="email" class="form-control" name="lg-email" placeholder="exemplo@teller.com" required/>
                        </div>
                        <div class="input-group custom-input-group">
                            <span class="input-group-addon">Senha: </span>
                            <input type="password" class="form-control" name="lg-password" placeholder="*****************" required/>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-lg custom-btn custom-btn-color">Entrar</button>
                    <h4 class="custom-regis-title">
                        Ainda não é cadastrado?
                    </h4>
                </form>
                <a href="<?= DynamicHtml::link_to('site/registration') ?>">
                    <button class="btn btn-lg custom-btn custom-btn-color">Registre-se</button>
                </a>
            </center>
        </div>
    </div>
</div>