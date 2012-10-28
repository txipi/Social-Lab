<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('post/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<?php echo $form['from_id'] ?>
<?php echo $form['is_public'] ?>
<?php echo $form['is_unread'] ?>
<div>
  <div class="select-big"><?php echo $form['to_id'] ?></div>
  <div><?php echo $form['text'] ?></div>
  <div class="float_r"><button type="submit" class="button confirm icon comment"><?php echo __('Send message') ?></button></div>
  <div class="cleaner"></div>
</div>
<div>
<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>
</div>
</form>
