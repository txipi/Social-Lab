    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Sign up') ?></h2>
  <form action="<?php echo url_for('register/index') ?>" method="post">
  <?php echo $form['_csrf_token']?>
  <div>
    <div>
      <?php echo $form['username']->renderLabel() ?>
      <?php echo $form['username']->render() ?>
      <?php echo $form['username']->renderError() ?>
    </div>
    <div>
      <?php echo $form['password']->renderLabel() ?>
      <?php echo $form['password'] ?>
      <?php echo $form['password']->renderError() ?>
    </div>
    <div>
      <?php echo $form['password_confirmation']->renderLabel() ?>
      <?php echo $form['password_confirmation'] ?>
      <?php echo $form['password_confirmation']->renderError() ?>
    </div>
    <div class="float_r"><button type="submit" class="button confirm icon key"><?php echo __('Sign up') ?></button></div>
    <div class="cleaner"></div>
  </div>
  <div>
    <?php echo $form->renderHiddenFields(false) ?>
    <?php echo $form->renderGlobalErrors() ?>
  </div>
  </form>
    </section>
    <div class="cleaner"></div>
    <br />

