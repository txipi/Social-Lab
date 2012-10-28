    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Friends') ?></h2>
<?php if ($sfGuardUserProfiles->getResults()->count() > 0): ?>
<?php foreach ($sfGuardUserProfiles->getResults() as $sfGuardUserProfile): ?>
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$sfGuardUserProfile->getId()) ?>"><img src="<?php if ($sfGuardUserProfile->getPhoto()) { echo '/uploads/profiles/small-'.$sfGuardUserProfile->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?>" class="small" /></a>
          </div>
          <div class="float_r">
            <?php echo link_to(__('Block friend'), 'profile/block?id='.$sfGuardUserProfile->getId(), array('class' => 'button confirm icon remove', 'confirm' => __('Are you sure?'))) ?>
          </div>
          <div class="float_l msg-text-big-buttons"><a href="<?php echo url_for('profile/show?id='.$sfGuardUserProfile->getId()) ?>"><?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <?php if($sfGuardUserProfiles->haveToPaginate()): ?>
      <div class="cleaner"></div>
      <br />
  <div class="pagination center">
    <a href="<?php echo url_for('profile/friends') ?>?page=<?php echo $sfGuardUserProfiles->getPreviousPage() ?>" class="button confirm"><</a>
    <?php foreach ($sfGuardUserProfiles->getLinks() as $page): ?>
      <?php if ($page == $sfGuardUserProfiles->getPage()): ?>
        <a href="<?php echo url_for('profile/friends') ?>?page=<?php echo $page ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/friends') ?>?page=<?php echo $page ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/friends') ?>?page=<?php echo $sfGuardUserProfiles->getNextPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
      <div class="cleaner"></div>
      <br />

<?php else: ?>
      <div class="fbinfobox"><?php echo __('You have no friends ;-(') ?></div>
      <br />
<?php endif; ?>
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

