    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Send a message to').' '.$profile->getFirstName().' '.$profile->getLastName() ?></h2>
      <?php include_partial('post/message', array('form' => $form)) ?>
    </section>
    <div class="cleaner"></div>
    <br />
