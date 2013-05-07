<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<form action="<?php echo url_for('profile/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php echo $form->renderHiddenFields(false) ?>
<?php if (!$form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
     <h3><?php echo __('Personal information') ?></h3>
      <div class="fbbluebox">
        <div class="float_l"><?php echo $form['first_name']->renderLabel() ?> <?php echo $form['first_name']->renderError() ?></div>
        <div class="float_r"><?php echo $form['first_name'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['last_name']->renderLabel() ?> <?php echo $form['last_name']->renderError() ?></div>
        <div class="float_r"><?php echo $form['last_name'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['email']->renderLabel() ?> <?php echo $form['email']->renderError() ?></div>
        <div class="float_r"><?php echo $form['email'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['gender']->renderLabel() ?> <?php echo $form['gender']->renderError() ?></div>
        <div class="float_r select-medium"><?php echo $form['gender'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['birthday']->renderLabel() ?> <?php echo $form['birthday']->renderError() ?></div>
        <div class="float_r select-small"><?php echo $form['birthday'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['photo']->renderLabel() ?> <?php echo $form['photo']->renderError() ?></div>
        <div class="float_r"><?php echo $form['photo'] ?></div>
        <div class="cleaner"></div>
      </div>
      <br />
      <h3><?php echo __('Location') ?></h3>
      <div class="fbbluebox">
        <div class="float_l"><?php echo $form['location_town']->renderLabel() ?> <?php echo $form['location_town']->renderError() ?></div>
        <div class="float_r"><?php echo $form['location_town'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['location_country']->renderLabel() ?> <?php echo $form['location_country']->renderError() ?></div>
        <div class="float_r"><?php echo $form['location_country'] ?></div>
        <div class="cleaner"></div>
      </div>
      <br />
      <h3><?php echo __('Academic information') ?></h3>
      <div class="fbbluebox">
        <div class="float_l"><?php echo $form['academic_title']->renderLabel() ?> <?php echo $form['academic_title']->renderError() ?></div>
        <div class="float_r"><?php echo $form['academic_title'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['academic_center']->renderLabel() ?> <?php echo $form['academic_center']->renderError() ?></div>
        <div class="float_r"><?php echo $form['academic_center'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['academic_promotion']->renderLabel() ?> <?php echo $form['academic_promotion']->renderError() ?></div>
        <div class="float_r"><?php echo $form['academic_promotion'] ?></div>
        <div class="cleaner"></div>
      </div>
      <br />
      <h3><?php echo __('Privacy settings') ?></h3>
      <div class="fbbluebox">
        <div class="float_l"><?php echo $form['personal_info_is_public']->renderLabel() ?> <?php echo $form['personal_info_is_public']->renderError() ?></div>
        <div class="float_r select-big"><?php echo $form['personal_info_is_public'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['location_info_is_public']->renderLabel() ?> <?php echo $form['location_info_is_public']->renderError() ?></div>
        <div class="float_r select-big"><?php echo $form['location_info_is_public'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['academic_info_is_public']->renderLabel() ?> <?php echo $form['academic_info_is_public']->renderError() ?></div>
        <div class="float_r select-big"><?php echo $form['academic_info_is_public'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['pictures_info_is_public']->renderLabel() ?> <?php echo $form['pictures_info_is_public']->renderError() ?></div>
        <div class="float_r select-big"><?php echo $form['pictures_info_is_public'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['pages_info_is_public']->renderLabel() ?> <?php echo $form['pages_info_is_public']->renderError() ?></div>
        <div class="float_r select-big"><?php echo $form['pages_info_is_public'] ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo $form['friends_info_is_public']->renderLabel() ?> <?php echo $form['friends_info_is_public']->renderError() ?></div>
        <div class="float_r select-big"><?php echo $form['friends_info_is_public'] ?></div>
        <div class="cleaner"></div>
      </div>
      <br />
      <h3><?php echo __('Research settings') ?></h3>
      <div class="fbbluebox">
        <div class="float_l"><?php echo $form['tos_accept']->renderLabel() ?> <?php echo $form['tos_accept']->renderError() ?></div>
        <div class="float_r select-big"><?php echo $form['tos_accept'] ?></div>
        <div class="cleaner"></div>
      </div>
      <br />
      <div class="float_r"><button type="submit" class="button confirm icon key"><?php echo __('Save changes') ?></button></div>
      <div class="cleaner"></div>
      <br />
<div>
<?php echo $form->renderHiddenFields(false) ?>
<?php echo $form->renderGlobalErrors() ?>
</div>
</form>
