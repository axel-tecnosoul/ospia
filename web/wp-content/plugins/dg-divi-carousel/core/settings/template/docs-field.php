<?php
    $link_text = (!empty($doc_url_text)) ? $doc_url_text : 'Learn more';
?>
<div class="settings-field">
    <?php if(!empty($doc_text)){?>
        <p><?php echo $doc_text; ?></p>
    <?php } ?>
    <?php if(!empty($doc_url)){?>
        <a href="<?php echo $doc_url; ?>" target="_blank"><?php echo $link_text; ?> <span>&#129122;</span></a>
    <?php } ?>
</div>