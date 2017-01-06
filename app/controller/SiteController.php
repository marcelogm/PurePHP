<?php
namespace App\Controller;
use Pure\Base\BaseController;
use Pure\Routes\Route;
use App\Util\Helpers;

class SiteController extends BaseController {

    public function index_action() {
        $this->menu['items'] = $this->main_menu_builder('home');
        $this->render_scaffold('pages/index');
    }

    public function about_action() {
        $this->menu['items'] = $this->main_menu_builder('about');
        $this->render_scaffold('pages/about');
    }

    public function login_action() {
        if ($this->params->from_POST('lg-email') && $this->params->from_POST('lg-password')) {
            $email = $this->params->from_POST('lg-email');
            $pass = $this->params->from_POST('lg-password');

            if (Helpers::authenticate($email, $pass)) {
                Helpers::redirect('dashboard/index');
                return;
            } else {
                $this->data['message'] = 'O email digitado ou a senha não conferem.';
            }
        }
        $this->menu['items'] = $this->main_menu_builder('login');
        $this->render_scaffold('pages/login');
    }

    public function logout_action() {
        $this->session->destroy();
        Helpers::redirect('site/index');
    }

    public function registration_action() {
        if ($this->params->from_POST('nome') &&
                $this->params->from_POST('email') &&
                $this->params->from_POST('password') &&
                $this->params->from_POST('repassword')) {
            $name = $this->params->from_POST('nome');
            $email = $this->params->from_POST('email');
            $pass = $this->params->from_POST('password');
            $repass = $this->params->from_POST('repassword');

            if (Helpers::validade_name($name)) {
                $this->data['message'] = 'Seu nome não pode conter caracteres especiais.';
            } else if (Helpers::validade_email($email) != 1) {
                $this->data['message'] = 'O email digitado não é válido.';
            } else if (Helpers::is_email_registered($email)) {
                $this->data['message'] = 'O email já foi cadastrado.';
            } else if (strlen($pass) < 5) {
                $this->data['message'] = 'As senhas digitadas devem ter mais de quatro caracteres.';
            } else if ($pass != $repass) {
                $this->data['message'] = 'As senhas digitadas não conferem.';
            } else {
                Helpers::registrate($name, $email, $pass);
                $this->data['feedback'] = 'Cadastro realizado com sucesso!';
                $this->login_action();
                return;
            }
        }
        $this->menu['items'] = $this->main_menu_builder();
        $this->render_scaffold('pages/registration');
    }

    private function render_scaffold($main) {
        $this->render('components/head');
        $this->render('components/header', $this->menu);
        $this->render($main, $this->data);
        $this->render('components/footer');
    }

    public function before_action() {
        $deny = [
            new Route('Site', 'login'),
            new Route('Site', 'registration')
        ];
        $this->menu['profile'] = (Helpers::is_authenticated()) ? $this->session->get('user_info') : null;

        if (Helpers::is_request_from($deny) && Helpers::is_authenticated()) {
            Helpers::redirect('dashboard/index');
            exit();
        }
    }

    private function main_menu_builder($active = '') {
        $menu = $this->menu_builder();

        if ($active != '') {
            $menu[$active]['active'] = true;
        }

        if (Helpers::is_authenticated()) {
            $menu['login']['enabled'] = false;
        } else {
            $menu['dashboard']['enabled'] = false;
        }
        return $menu;
    }

    private function menu_builder() {
        return [
            'home' => ['title' => 'Home', 'url' => 'site/index', 'enabled' => true, 'active' => false],
            'about' => ['title' => 'Sobre', 'url' => 'site/about', 'enabled' => true, 'active' => false],
            'login' => ['title' => 'Entrar', 'url' => 'site/login', 'enabled' => true, 'active' => false],
            'dashboard' => ['title' => 'Painel', 'url' => 'dashboard/index', 'enabled' => true, 'active' => false]
        ];
    }

}
