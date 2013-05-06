    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Welcome to Social Lab privacy wargame!') ?></h2>
      <p><?php echo __('<strong>Social Lab privacy wargame</strong> is <strong>NOT</strong> a real social network. If you want to know what it is') ?>, <?php echo link_to(__('click here'), 'default/social') ?> ;)</p>
      <h3><?php echo __('Sign in') ?></h3>
  <form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
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
      <small id="remember-me-option">
        <?php echo $form['remember'] ?><span><?php echo $form['remember']->renderLabel() ?></span>
      </small>
    </div>
    <div class="float_r"><button type="submit" class="button confirm icon lock"><?php echo __('Sign in') ?></button></div>
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

