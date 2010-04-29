<div style="margin-left:10px;margin-right:10px" id="content_part"><?php
if (!defined("PROPER_INCLUDE"))die;
?>
<?php if ($View->keyExists("page")): ?>
<h1><?= $View->page['title']; ?></h1>
<?= $View->page['text']; ?>

<div style="text-align: right;"><small><em><?= date("d/m/Y H:i",$View->page['date']); ?></em></small></div>
<?php else: ?>
<h1><?= i18n::get("page_notfound_header");?></h1>
<?= i18n::get("page_notfound_text");?>
<?php endif; ?>
</div>