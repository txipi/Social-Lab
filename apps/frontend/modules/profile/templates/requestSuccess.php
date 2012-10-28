    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Friendship request') ?></h2>
      <div>
        <div><?php echo __('Asking <strong>%name%</strong> to be a friend...', array('%name%' => $profile->getFirstName().' '.$profile->getLastName())) ?></div>
        <br />
        <?php include_partial('request/friend', array('form' => $form)) ?>
        <br />
      </div>
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

