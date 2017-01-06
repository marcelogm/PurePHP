<?php
namespace App\View\Components;
use App\Util\DynamicHtml;
use App\Util\Helpers;
?>

<?php DynamicHtml::error_message(isset($message) ? $message : null); ?>
<?php DynamicHtml::feedback_message(isset($feedback) ? $feedback : null); ?>
<?php if (isset($day)): ?>
    <h3 class="custom-color">
        Mostrando lançamentos de <?= Helpers::display_date($day) ?>
        <br/>
        <small>
            Total de movimentações no dia: <?= $count ?>
        </small>
    </h3>
<?php endif; ?>
<?php DynamicHtml::table($items, $total); ?>
<div>
    <center>
        <?php DynamicHtml::paginate($count, 'paginateDay'); ?>
    </center>
</div>