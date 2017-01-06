<?php
namespace App\View\Components;
use App\Util\DynamicHtml;
use App\Util\Helpers;
?>

<?php DynamicHtml::error_message(isset($message) ? $message : null); ?>
<?php DynamicHtml::feedback_message(isset($feedback) ? $feedback : null); ?>
<?php if (isset($begin)): ?>
    <h3 class="custom-color">
        Mostrando lançamentos de <?= Helpers::display_date($begin) ?> à <?= Helpers::display_date($end) ?>
        <br/>
        <small>
            Total de movimentações no período: <?= $count ?>
        </small>
    </h3>
<?php endif; ?>
<?php
DynamicHtml::table($items, $total);
?>
<div>
    <center>
        <?php DynamicHtml::paginate($count, 'paginatePeriod'); ?>
    </center>
</div> 