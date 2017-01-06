<?php
namespace App\View\Components;
use App\Util\DynamicHtml;
use App\Util\Helpers;
?>

<?php DynamicHtml::error_message(isset($message) ? $message : null); ?>
<?php DynamicHtml::feedback_message(isset($feedback) ? $feedback : null); ?>
<?php if (isset($month)): ?>
    <h3 class="custom-color">
        Mostrando de lançamento de <?= Helpers::display_month($month) ?>
        <br/>
        <small>
            Total de movimentações no mês: <?= $count ?>
        </small>
    </h3>
<?php endif; ?>
<?php
DynamicHtml::table($items, $total);
?>
<div>
    <center>
        <?php DynamicHtml::paginate($count, 'paginateMonth'); ?>
    </center>
</div>

