<div class="field<?php echo $dg_class;?>">
    <div class="field-label"><?php echo $field['title']; ?></div>
    <?php call_user_func($field['callback'], $field['args']);?>
    <?php echo $class;?>
</div>