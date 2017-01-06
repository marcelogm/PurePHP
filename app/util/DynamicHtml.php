<?php
namespace App\Util;
use App\Util\ParamsManager;

class DynamicHtml {

    public static function link_boostrap() {
        return '<link href="' . DOMAIN . 'app/view/stylesheets/css/bootstrap.css" rel="stylesheet">';
    }

    public static function link_css($link) {
        return '<link href="' . DOMAIN . 'app/view/stylesheets/css/' . $link . '" rel="stylesheet">';
    }

    public static function script($name) {
        return '<script src="' . DOMAIN . 'app/view/stylesheets/js/' . $name . '"></script>';
    }

    public static function link_to($path) {
        return DOMAIN . $path;
    }

    public static function navbar_item($item) {
        if ($item['enabled'] == true) {
            echo '<li';
            if ($item['active']) {
                echo ' class="active"';
            }
            echo '>';
            echo '<a href="' . DOMAIN . $item['url'] . '">' . $item['title'] . '</a>';
            echo '</li>';
        }
    }

    public static function dropdown_profile($info) {
        echo '<li class="dropdown">';
        echo '<a href="' . DynamicHtml::link_to('dashboard/profile') . '" class="dropdown-toggle" data-toggle="dropdown">';
        echo $info->name;
        echo ' <b class="caret"></b></a>';
        echo '<ul class="dropdown-menu">';
        echo '<li><a href="' . DynamicHtml::link_to('dashboard/index') . '">Painel</a></li>';
        echo '<li><a href="' . DynamicHtml::link_to('site/logout') . '">Sair</a></li>';
        echo '</ul>';
        echo '</li>';
    }

    public static function error_message($text = null) {
        if ($text != null) {
            echo '<div class="alert alert-danger">';
            echo '<strong>Ops!</strong> ' . $text;
            echo '</div>';
        }
    }

    public static function feedback_message($text = null) {
        if ($text != null) {
            echo '<div class="alert alert-info">';
            echo '<strong>Pronto!</strong> ' . $text;
            echo '</div>';
        }
    }

    public static function image_circle($name = null) {
        if ($name != null) {
            echo '<img class="img-circle" src="' . DOMAIN . 'app/images/' . $name . '" alt="Generic placeholder image" height="200" width="200">';
        }
    }

    public static function table_header($titles = null) {
        if ($titles != null) {
            echo '<thead><tr>';
            foreach ($titles as $title) {
                echo '<th>' . $title . '</th>';
            }
            echo '</thead></tr>';
        }
    }

    public static function table_balance_item($item = null) {
        if ($item != null) {
            if ($item->value > 0) {
                echo '<tr class="success">';
            } else {
                echo '<tr class="danger">';
            }
            echo '<th>' . $item->name . '</th>';
            echo '<th> R$ ' . $item->value . '</th>';
            echo '<th>' . Helpers::display_date($item->date) . '</th>';
            echo '<th><a href="' . DynamicHtml::link_to('dashboard/delete') . '/' . $item->id . '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></th>';
            echo '</tr>';
        }
    }

    public static function paginate($total = null, $jsMethod = 'paginatePeriod', $per_page = 10) {
        $amout = intval($total / $per_page);
        if (($total % $per_page) != 0) {
            $amout++;
        }
        $params = ParamsManager::get_instance();
        $current = ($params->get('offset') == null) ? 1 : $params->get('offset');
        if ($amout != null) {
            echo '<nav aria-label="paginacao">';
            echo '<ul class="pagination">';
            for ($i = 1; $i <= $amout; $i++) {
                if ($i == $current) {
                    echo '<li class="active"><a onclick="' . $jsMethod . '(' . $i . ')">' . $i . '</a></li>';
                } else {
                    echo '<li><a onclick="' . $jsMethod . '(' . $i . ')">' . $i . '</a></li>';
                }
            }
            echo '</ul></nav>';
        }
    }

    public static function table_total($item) {
        if ($item != null) {
            if ($item > 0) {
                echo '<tr class="success">';
            } else {
                echo '<tr class="danger">';
            }
            echo '<th> Total </th><th></th><th></th>';
            echo '<th> R$ ' . $item . '</th>';
            echo '</tr>';
        }
    }

    public static function table($items, $total) {
        if (isset($items) && $items != null && isset($total) && $total != null) {
            echo '<table class="table table-striped" id="period-table">';
            DynamicHtml::table_header(['Descrição', '', '', 'Valor']);
            DynamicHtml::table_total($total);
            DynamicHtml::table_header(['Nome', 'Valor', 'Data']);

            foreach ($items as $item) {
                DynamicHtml::table_balance_item($item);
            }
            echo '</table>';
        }
    }

}
