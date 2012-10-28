<?php use_helper('Date') ?>
    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Requests') ?></h2>
      <h3><?php echo __('Incoming') ?></h3>
<?php if($inbox->getResults()->count() > 0): ?>
  <?php foreach ($inbox->getResults() as $Request): ?>
      <article>
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$Request->getsfGuardUserProfileRelatedByFromId()->getId()) ?>"><img src="<?php if ($Request->getsfGuardUserProfileRelatedByFromId()->getPhoto()) { echo '/uploads/profiles/small-'.$Request->getsfGuardUserProfileRelatedByFromId()->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $Request->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Request->getsfGuardUserProfileRelatedByFromId()->getLastName() ?>" class="small" /></a><br />
          </div>
          <div class="float_l msg-text-buttons"><?php echo strip_tags(nl2br($Request->getText(ESC_RAW)), '<br/><br><a>') ?></div>
          <div class="cleaner"></div>
        </div>
        <div class="float_r">
          <?php 
            echo __('%user% asked to be a friend (%time% ago)', array('%user%' => '<strong><a href="'.url_for('profile/show?id='.$Request->getsfGuardUserProfileRelatedByFromId()->getId()).'">'.$Request->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Request->getsfGuardUserProfileRelatedByFromId()->getLastName().'</a></strong>', '%time%' => distance_of_time_in_words(Social::getUnixTimestamp(), Social::getUnixTimestamp($Request->getUpdatedAt())))) 
          ?>
          <?php switch ($Request->getStatus()) {
             case sfConfig::get('app_status_pending'): ?>
          <br />
        </div>
        <div class="cleaner"></div>
        <div class="float_r button-group">
          <?php
               echo '<a href="'.url_for('request/accept?id='.$Request->getId()).'" class="button confirm icon approve">'.__('Accept').'</a>';
               echo '<a href="'.url_for('request/reject?id='.$Request->getId()).'" class="button confirm icon remove">'.__('Reject').'</a>';
               echo '<a href="'.url_for('request/message?id='.$Request->getId()).'" class="button confirm icon comment">'.__('Send message').'</a>';
               break;
             case sfConfig::get('app_status_accepted'):
               echo __('and was <strong>accepted</strong>');
               break;
             case sfConfig::get('app_status_rejected'):
               echo __('and was <strong>rejected</strong>');
               break;
           } ?>
        </div>
        <div class="cleaner"></div>
        <br />
      </article>
  <?php endforeach; ?>
  <?php if($inbox->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/requests') ?>?pagein=<?php echo $inbox->getPreviousPage() ?>&pageout=<?php echo $outbox->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($inbox->getLinks() as $page): ?>
      <?php if ($page == $inbox->getPage()): ?>
        <a href="<?php echo url_for('profile/requests') ?>?pagein=<?php echo $page ?>&pageout=<?php echo $outbox->getPage() ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/requests') ?>?pagein=<?php echo $page ?>&pageout=<?php echo $outbox->getPage() ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/requests') ?>?pagein=<?php echo $inbox->getNextPage() ?>&pageout=<?php echo $outbox->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <article>
        <div class="fbinfobox"><?php echo __('There are <strong>no</strong> incoming friendship requests.') ?></div>
        <br />
      </article>
<?php endif; ?> 
      <h3><?php echo __('Sent') ?></h3>
<?php if($outbox->getResults()->count() > 0): ?>
  <?php foreach ($outbox->getResults() as $Request): ?>
      <article>
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$Request->getsfGuardUserProfileRelatedByFromId()->getId()) ?>"><img src="<?php if ($Request->getsfGuardUserProfileRelatedByFromId()->getPhoto()) { echo '/uploads/profiles/small-'.$Request->getsfGuardUserProfileRelatedByFromId()->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $Request->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Request->getsfGuardUserProfileRelatedByFromId()->getLastName() ?>" class="small" /></a><br />
          </div>
          <div class="float_l msg-text-buttons"><?php echo strip_tags(nl2br($Request->getText(ESC_RAW)), '<br/><br><a>') ?></div>
          <div class="cleaner"></div>
        </div>
        <div class="float_r">
          <?php 
            echo '<strong><a href="'.url_for('profile/show?id='.$Request->getsfGuardUserProfileRelatedByToId()->getId()).'">'.$Request->getsfGuardUserProfileRelatedByToId()->getFirstName().' '.$Request->getsfGuardUserProfileRelatedByToId()->getLastName().'</a></strong> ' 
          ?>
          <?php switch ($Request->getStatus()) {
             case sfConfig::get('app_status_pending'):
               echo __('was asked to be a friend');
               break;
             case sfConfig::get('app_status_accepted'):
               echo __('<strong>accepted</strong> to be a friend');
               break;
             case sfConfig::get('app_status_accepted'):
               echo __('<strong>rejected</strong> to be a friend');
               break;
           } 
          echo ' '.__('(%time% ago)', array('%time%' => distance_of_time_in_words(Social::getUnixTimestamp(), Social::getUnixTimestamp($Request->getUpdatedAt()))));
          ?>
        </div>
        <div class="cleaner"></div>
        <br />
      </article>
  <?php endforeach; ?>
  <?php if($outbox->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/requests') ?>?pageout=<?php echo $outbox->getPreviousPage() ?>&pagein=<?php echo $inbox->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($outbox->getLinks() as $page): ?>
      <?php if ($page == $outbox->getPage()): ?>
        <a href="<?php echo url_for('profile/requests') ?>?pageout=<?php echo $page ?>&pagein=<?php echo $inbox->getPage() ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/requests') ?>?pageout=<?php echo $page ?>&pagein=<?php echo $inbox->getPage() ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/requests') ?>?pageout=<?php echo $outbox->getNextPage() ?>&pagein=<?php echo $inbox->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <article>
        <div class="fbinfobox"><?php echo __('There are <strong>no</strong> sent friendship requests.') ?></div>
        <br />
      </article>
<?php endif; ?> 
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

