<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('pic/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
<?php echo $form['owner_id'] ?>
<div>
  <div>
    <div class="float_l"><strong><?php echo $form['title']->renderLabel() ?></strong> <?php echo $form['title']->renderError() ?></div>
    <div class="float_r"><?php echo $form['title'] ?></div>
    <div class="cleaner"></div>
  </div>
  <br />
  <div>
    <div class="float_l"><strong><?php echo $form['photo']->renderLabel() ?></strong> <?php echo $form['photo']->renderError() ?></div>
    <div class="cleaner"></div>
    <br />
    <div><?php echo $form['photo'] ?></div>
    <div class="cleaner"></div>
  </div>
  <br />
  <div class="float_r"><button type="submit" class="button confirm icon key"><?php echo __('Save') ?></button></div>
  <div class="cleaner"></div>
</div>
<div>
<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>
</div>
</form>
