<?php
namespace App\Controller;
use Pure\Base\BaseController;
use Pure\Routes\Route;
use App\Util\Helpers;
use App\Model\Facade;

class DashboardController extends BaseController {

    public function index_action() {
        $f = Facade::get_instance();

        $this->data['insert_items'] = $f->select_balance_offset($this->session->get('user_id'));
        $this->menu['items'] = $this->main_menu_builder('dashboard');
        $this->render_scaffold('pages/dashboard');
    }

    public function insert_action() {
        $f = Facade::get_instance();
        $balance = Helpers::get_balance_from_POST();

        if ($balance != null) {
            $f->save_balance($balance);
            $this->data['items'] = $f->select_balance_offset($this->session->get('user_id'));
            $this->data['feedback'] = 'Conta inserida!';
        } else {
            $this->data['items'] = $f->select_balance_offset($this->session->get('user_id'));
            $this->data['message'] = 'Erro ao inserir cadastro!';
        }
        $this->render('components/insert', $this->data);
    }

    public function period_action() {
        $f = Facade::get_instance();

        $begin = $this->params->get('p_begin');
        $end = $this->params->get('p_end');
        $offset = $this->params->get('offset');
        $user = $this->session->get('user_id');

        $this->data['count'] = null;
        $this->data['items'] = null;
        $this->data['total'] = null;

        if ($begin != null && $end != null) {
            $begin = Helpers::parse_date($begin);
            $end = Helpers::parse_date($end);

            $this->data['begin'] = $begin;
            $this->data['end'] = $end;
            $this->data['total'] = $f->get_period_sum_from($user, $begin, $end);
            $this->data['count'] = $f->count_period_from($user, $begin, $end);
            if ($offset != null) {
                $this->data['items'] = $f->select_balance_for_period($user, $begin, $end, 10, $offset);
            } else {
                $this->data['items'] = $f->select_balance_for_period($user, $begin, $end, 10);
            }
            $this->render('components/period', $this->data);
            return;
        }
        $this->data['message'] = 'Preencha os periodos corretamente.';
        $this->render('components/period', $this->data);
    }

    public function month_action() {
        $f = Facade::get_instance();

        $month = $this->params->get('m_date');
        $offset = $this->params->get('offset');
        $user = $this->session->get('user_id');

        $this->data['count'] = null;
        $this->data['items'] = null;
        $this->data['total'] = null;

        if ($month != null) {
            $month = Helpers::parse_month($month);

            $this->data['month'] = $month;
            $this->data['count'] = $f->count_month_from($user, $month);
            $this->data['total'] = $f->get_month_sum_from($user, $month);

            if ($offset != null) {
                $this->data['items'] = $f->select_balance_for_month($user, $month, 10, $offset);
            } else {
                $this->data['items'] = $f->select_balance_for_month($user, $month, 10);
            }
            $this->render('components/month', $this->data);
            return;
        }
        $this->data['message'] = 'Preencha os periodos corretamente.';
        $this->render('components/month', $this->data);
    }

    public function day_action() {
        $f = Facade::get_instance();

        $day = $this->params->get('d_date');
        $offset = $this->params->get('offset');
        $user = $this->session->get('user_id');

        $this->data['count'] = null;
        $this->data['items'] = null;
        $this->data['total'] = null;

        if ($day != null) {
            $day = Helpers::parse_date($day);

            $this->data['day'] = $day;
            $this->data['count'] = $f->count_day_from($user, $day);
            $this->data['total'] = $f->get_day_sum_from($user, $day);
            if ($offset != null) {
                $this->data['items'] = $f->select_balance_for_day($user, $day, 10, $offset);
            } else {
                $this->data['items'] = $f->select_balance_for_day($user, $day, 10);
            }
            $this->render('components/day', $this->data);
            return;
        }
        $this->data['message'] = 'Preencha os periodos corretamente.';
        $this->render('components/day', $this->data);
    }

    public function delete_action($id) {
        $f = Facade::get_instance();
        if ($id != null) {
            $balance = $f->select_balance($id);
            if ($balance != null) {
                $f->delete_balance($id);
                Helpers::redirect('dashboard/index');
                return;
            }
        }
        var_dump($id);
        Helpers::redirect('dashboard/index');
        return;
    }

    private function render_scaffold($main) {
        $this->render('components/head');
        $this->render('components/header', $this->menu);
        $this->render($main, $this->data);
        $this->render('components/footer');
    }

    public function before_action() {
        $deny = [
            new Route('Dashboard', 'index'),
            new Route('Dashboard', 'profile'),
            new Route('Dashborad', 'insert'),
            new Route('Dashborad', 'period'),
            new Route('Dashborad', 'month'),
            new Route('Dashborad', 'day'),
            new Route('Dashborad', 'delete')
        ];

        $this->menu['profile'] = (Helpers::is_authenticated()) ? $this->session->get('user_info') : null;

        if (Helpers::is_request_from($deny) && !Helpers::is_authenticated()) {
            Helpers::redirect('site/login');
        }
    }

    private function main_menu_builder($active = '') {
        $menu = $this->menu_builder();
        if ($active != '') {
            $menu[$active]['active'] = true;
        }
        return $menu;
    }

    private function menu_builder() {
        return [
            'home' => ['title' => 'Home', 'url' => 'site/index', 'enabled' => true, 'active' => false],
            'dashboard' => ['title' => 'Painel', 'url' => 'dashboard/index', 'enabled' => true, 'active' => false],
        ];
    }

}
