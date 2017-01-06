<?php
namespace App\Controller;
use Pure\Base\BaseController;

class ErrorController extends BaseController {

    public function index_action() {
        $data = [];
        $menu['items'] = $this->menu_builder();
        $this->render_scaffold('pages/error', $data, $menu);
    }

    public function render_scaffold($main, $data = [], $menu) {
        $this->render('components/head');
        $this->render('components/header', $menu);
        $this->render($main, $data);
        $this->render('components/footer');
    }

    private function menu_builder() {
        return [
            'home' => ['title' => 'Home', 'url' => 'site/index', 'enabled' => true, 'active' => false]
        ];
    }

}
