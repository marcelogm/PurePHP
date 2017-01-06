<?php
namespace App\View\Components;
use App\Util\DynamicHtml;
?>

<?php DynamicHtml::error_message(isset($message) ? $message : null); ?>
<?php DynamicHtml::feedback_message(isset($feedback) ? $feedback : null); ?>
<table class="table table-striped" id="insert-table">
    <?php DynamicHtml::table_header(['Nome', 'Valor', 'Data']) ?>
    <?php
    if (isset($items)):
        foreach ($items as $item):
            DynamicHtml::table_balance_item($item);
        endforeach;
    endif;
    ?>
</table>