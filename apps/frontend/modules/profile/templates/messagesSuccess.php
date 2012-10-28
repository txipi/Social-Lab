<?php use_helper('Date', 'Escaping') ?>
    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Messages') ?></h2>
      <h3><?php echo __('Send a message...') ?></h3>
      <div>
        <?php include_partial('post/message', array('form' => $form)) ?>
        <br />
      </div>
      <h3><?php echo __('Inbox') ?></h3>
<?php if($inbox->getResults()->count() > 0): ?>
  <?php foreach ($inbox->getResults() as $Message): ?>
      <article>
        <?php if ($Message->getIsUnread()) : ?>
        <div class="fbgreybox">
        <?php else: ?>
        <div class="fbbluebox read">
        <?php endif; ?>
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$Message->getsfGuardUserProfileRelatedByFromId()->getId()) ?>"><img src="<?php if ($Message->getsfGuardUserProfileRelatedByFromId()->getPhoto()) { echo '/uploads/profiles/small-'.$Message->getsfGuardUserProfileRelatedByFromId()->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $Message->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Message->getsfGuardUserProfileRelatedByFromId()->getLastName() ?>" class="small" /></a>
          </div>
          <div class="float_r">
          <?php if ($Message->getIsUnread()) {
             echo link_to(__('Mark as read'), 'post/read?id='.$Message->getId(), array('class' => 'button confirm icon remove'));
           } else { 
             echo link_to(__('Mark as unread'), 'post/unread?id='.$Message->getId(), array('class' => 'button confirm icon approve'));
           } ?>
          </div>
          <div class="float_l msg-text-big-buttons"><?php echo strip_tags(nl2br($Message->getText(ESC_RAW)), '<br/><br><a>') ?></div>
          <div class="cleaner"></div>
        </div>
        <div class="float_r">
          <?php 
            echo '<strong><a href="'.url_for('profile/show?id='.$Message->getsfGuardUserProfileRelatedByFromId()->getId()).'">'.$Message->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Message->getsfGuardUserProfileRelatedByFromId()->getLastName().'</a></strong> '.__('(%time% ago)', array('%time%' => distance_of_time_in_words(Social::getUnixTimestamp(), Social::getUnixTimestamp($Message->getUpdatedAt())))) 
          ?>
        </div>
        <div class="cleaner"></div>
        <br />
      </article>
  <?php endforeach; ?>
  <?php if($inbox->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/messages') ?>?pagein=<?php echo $inbox->getPreviousPage() ?>&pageout=<?php echo $outbox->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($inbox->getLinks() as $page): ?>
      <?php if ($page == $inbox->getPage()): ?>
        <a href="<?php echo url_for('profile/messages') ?>?pagein=<?php echo $page ?>&pageout=<?php echo $outbox->getPage() ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/messages') ?>?pagein=<?php echo $page ?>&pageout=<?php echo $outbox->getPage() ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/messages') ?>?pagein=<?php echo $inbox->getNextPage() ?>&pageout=<?php echo $outbox->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <article>
        <div class="fbinfobox"><?php echo __('There are <strong>no</strong> personal messages for this profile.') ?></div>
        <br />
      </article>
<?php endif; ?> 
      <h3><?php echo __('Outbox') ?></h3>
<?php if($outbox->getResults()->count() > 0): ?>
  <?php foreach ($outbox->getResults() as $Message): ?>
      <article>
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$Message->getsfGuardUserProfileRelatedByToId()->getId()) ?>"><img src="<?php if ($Message->getsfGuardUserProfileRelatedByToId()->getPhoto()) { echo '/uploads/profiles/small-'.$Message->getsfGuardUserProfileRelatedByToId()->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $Message->getsfGuardUserProfileRelatedByToId()->getFirstName().' '.$Message->getsfGuardUserProfileRelatedByToId()->getLastName() ?>" class="small" /></a><br />
          </div>
          <div class="float_l msg-text-big-buttons"><?php echo strip_tags(nl2br($Message->getText(ESC_RAW)), '<br/><br><a>') ?></div>
          <div class="cleaner"></div>
        </div>
        <div class="float_r">
          <?php 
            echo '<strong><a href="'.url_for('profile/show?id='.$Message->getsfGuardUserProfileRelatedByFromId()->getId()).'">'.$Message->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Message->getsfGuardUserProfileRelatedByFromId()->getLastName().'</a></strong> '.__('(%time% ago)', array('%time%' => distance_of_time_in_words(Social::getUnixTimestamp(), Social::getUnixTimestamp($Message->getUpdatedAt())))) 
          ?>
        </div>
        <div class="cleaner"></div>
        <br />
      </article>
  <?php endforeach; ?>
  <?php if($outbox->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/messages') ?>?pageout=<?php echo $outbox->getPreviousPage() ?>&pagein=<?php echo $inbox->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($outbox->getLinks() as $page): ?>
      <?php if ($page == $outbox->getPage()): ?>
        <a href="<?php echo url_for('profile/messages') ?>?pageout=<?php echo $page ?>&pagein=<?php echo $inbox->getPage() ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/messages') ?>?pageout=<?php echo $page ?>&pagein=<?php echo $inbox->getPage() ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/messages') ?>?pageout=<?php echo $outbox->getNextPage() ?>&pagein=<?php echo $inbox->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <article>
        <div class="fbinfobox"><?php echo __('There are <strong>no</strong> personal messages from this profile.') ?></div>
        <br />
      </article>
<?php endif; ?> 
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

