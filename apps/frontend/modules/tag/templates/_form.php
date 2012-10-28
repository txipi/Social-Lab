<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('tag/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<?php echo $form['picture_id'] ?>
<div>
  <div>
    <div class="float_l select-big"><?php echo $form['user_id'] ?></div>
    <div class="float_r"><button type="submit" class="button confirm icon tag"><?php echo __('Tag') ?></button></div>
    <div class="cleaner"></div>
  </div>
  <br />
  <br />
</div>
<div>
<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>
</div>
</form>
