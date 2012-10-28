<?php use_helper('Date') ?>
    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('The wall of %user%', array('%user%' => $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName())) ?></h2>
      <?php include_partial('post/status', array('form' => $form)) ?>
<?php if($posts->getResults()->count() > 0): ?>
  <?php foreach ($posts->getResults() as $Message): ?>
      <article>
        <br />
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$Message->getsfGuardUserProfileRelatedByFromId()->getId()) ?>"><img src="<?php if ($Message->getsfGuardUserProfileRelatedByFromId()->getPhoto()) { echo '/uploads/profiles/small-'.$Message->getsfGuardUserProfileRelatedByFromId()->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $Message->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Message->getsfGuardUserProfileRelatedByFromId()->getLastName() ?>" class="small" /></a>
          </div>
        <?php if ($Message->getFromId() == $sfGuardUserProfile->getId()): ?>
          <div class="float_r">
          <?php echo link_to(__('Delete'), 'post/delete?id='.$Message->getId(), array('class' => 'button confirm icon remove', 'method' => 'delete', 'confirm' => __('Are you sure?'))) ?>
          </div>
        <?php endif; ?>
          <div class="float_l msg-text-buttons"><?php echo strip_tags(nl2br($Message->getText(ESC_RAW)), '<br/><br><a>') ?></div>
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
  <?php if($posts->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/wall') ?>?page=<?php echo $posts->getPreviousPage() ?>" class="button confirm"><</a>
    <?php foreach ($posts->getLinks() as $page): ?>
      <?php if ($page == $posts->getPage()): ?>
        <a href="<?php echo url_for('profile/wall') ?>?page=<?php echo $page ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/wall') ?>?page=<?php echo $page ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/wall') ?>?page=<?php echo $posts->getNextPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <article>
        <br />
        <div class="fbinfobox"><?php echo __('There are <strong>no</strong> posts on this wall.') ?></div>
        <br />
      </article>
<?php endif; ?> 
    <br />
    </section>
    <div class="cleaner"></div>
    <br />
