<?php
namespace App\View\Pages;
use App\Util\DynamicHtml;
?>

<div class="custom-background-simple container-fluid">
    <br/>
    <div class="container">
        <!-- PANEL -->
        <div class="panel panel-default">
            <!-- PANEL HEADER -->
            <div class="panel-heading">
                <h1 class="">Painel de contabilidade</h1>
            </div>
            <!-- PANEL BODY -->
            <div class="panel-body">
                <!-- NAV TABS -->
                <ul class="nav nav-tabs">
                    <!-- NAV ITEM -->
                    <li class="active">
                        <a data-toggle="tab" href="#insert">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Novo lançamento
                        </a>
                    </li>
                    <!-- NAV ITEM -->
                    <li>
                        <a data-toggle="tab" href="#period">
                            <span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span> Saldo de periodo
                        </a>
                    </li>
                    <!-- NAV ITEM -->
                    <li>
                        <a data-toggle="tab" href="#month">
                            <span class="glyphicon glyphicon-tags" aria-hidden="true"></span> Saldo mensal
                        </a>
                    </li>
                    <!-- NAV ITEM -->
                    <li>
                        <a data-toggle="tab" href="#daily">
                            <span class="glyphicon glyphicon-tag" aria-hidden="true"></span> Saldo diário
                        </a>
                    </li>
                </ul>
                <!-- NAV CONTENT -->
                <div class="tab-content">
                    <!-- INSERT -->
                    <div id="insert" class="tab-pane fade in active">
                        <div class="container-fluid">
                            <br />
                            <!-- JUMBOTRON -->
                            <div class="jumbotron">
                                <!-- TITULO -->
                                <h2 class="custom-color">
                                    <center>
                                        Cadastre suas despesas e lançamentos.
                                        <br />
                                        <small>Aqui você pode cadastrar suas despesas e organizaremos isso para você.</small>
                                    </center>
                                </h2>
                                <br />
                                <!-- CADASTRAR -->
                                <form class="form-inline" id="insert-form" method="POST">
                                    <center>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-addon">Nome: </div>
                                                    <input type="text" class="form-control" name="i_name" placeholder="" />
                                                </div>
                                                <div class="input-group">
                                                    <div class="input-group-addon">R$ </div>
                                                    <input class="form-control" name="i_value" type="number" min="1" step="any" />
                                                </div>
                                                <div class='input-group datepicker'>
                                                    <div class="input-group-addon">Data: </div>
                                                    <input type='text' class="form-control" id="i_date" name="i_date" placeholder="" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                                <select class="input-group form-control" name="i_type">
                                                    <option>Credito</option>
                                                    <option>Debito</option>
                                                </select>
                                            </div>
                                            <button type="submit" id="insert-balance" class="btn btn-primary custom-btn-color input-group">Inserir</button>
                                        </div>
                                    </center>
                                </form>
                            </div>
                            <!-- LISTA -->
                            <h3 class="custom-color">Suas últimas cinco interações</h3>
                            <div id="insert-binding">
                                <table class="table table-striped">
                                    <?php DynamicHtml::table_header(['Nome', 'Valor', 'Data']) ?>
                                    <?php
                                    if (isset($insert_items)):
                                        foreach ($insert_items as $item):
                                            DynamicHtml::table_balance_item($item);
                                        endforeach;
                                    endif;
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- PERIOD -->
                    <div id="period" class="tab-pane fade">
                        <div class="container-fluid">
                            <br/>
                            <div class="jumbotron">
                                <!-- TITULO -->
                                <h2 class="custom-color">
                                    <center>
                                        Escolha o periodo que deseja visualizar
                                        <br />
                                        <small>Você pode consultar suas contas entre uma data específica.</small>
                                    </center>
                                </h2>
                                <br/>
                                <!-- SELECAO -->
                                <form class="form-inline" id="period-form" method="POST">
                                    <center>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <div class='input-group datepicker'>
                                                    <div class="input-group-addon">Início: </div>
                                                    <input type='text' class="form-control" id="p_begin" name="p_begin"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                                entre
                                                <div class='input-group datepicker'>
                                                    <div class="input-group-addon">Final: </div>
                                                    <input type='text' class="form-control" id="p_end" name="p_end"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary custom-btn-color input-group">Consultar</button>
                                        </div>
                                    </center>
                                </form>
                            </div>
                            <!-- LISTA -->
                            <div id="period-binding">
                            </div>
                        </div>
                    </div>
                    <!-- MONTH -->
                    <div id="month" class="tab-pane fade">
                        <div class="container-fluid">
                            <br/>
                            <div class="jumbotron">
                                <!-- TITULO -->
                                <h2 class="custom-color">
                                    <center>
                                        Obtenha o relatório completo de determinado mês.
                                        <br />
                                        <small>Consulte os débitos e os créditos referentes ao mês escolhido</small>
                                    </center>
                                </h2>
                                <br/>
                                <!-- SELECAO -->
                                <form class="form-inline" id="month-form" method="POST">
                                    <center>
                                        <div class="form-group">
                                            <div class='input-group monthpicker'>
                                                <div class="input-group-addon">Mês: </div>
                                                <input type='text' class="form-control" id="m_date" name="m_date"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary custom-btn-color input-group">Consultar</button>
                                    </center>
                                </form>
                            </div>
                            <!-- LISTA -->
                            <div id="month-binding">
                            </div>
                        </div>
                    </div>
                    <!-- DAILY -->
                    <div id="daily" class="tab-pane fade">
                        <div class="container-fluid">
                            <br/>
                            <div class="jumbotron">
                                <!-- TITULO -->
                                <h2 class="custom-color">
                                    <center>
                                        Obtenha o relatório completo de determinado dia.
                                        <br />
                                        <small>Consulte os débitos e os créditos referentes ao dia escolhido</small>
                                    </center>
                                </h2>
                                <br/>
                                <!-- SELECAO -->
                                <form class="form-inline" id="day-form" method="POST">
                                    <center>
                                        <div class="form-group">
                                            <div class='input-group datepicker'>
                                                <div class="input-group-addon">Dia: </div>
                                                <input type='text' class="form-control" id="d_date" name="d_date"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                            <button type="submit" class="btn btn-primary custom-btn-color input-group">Consultar</button>
                                        </div>
                                    </center>
                                </form>
                            </div>
                            <!-- LISTA -->
                            <div id="day-binding">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
