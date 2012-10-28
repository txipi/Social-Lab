    <?php include_partial('profile/aside') ?>
    <section id="content">
      <div class="float_l"><h2><?php echo __('%title% fan page', array('%title%' => $Page->getTitle())) ?></h2></div>
      <?php if ($isOwner): ?>
      <div class="float_r button-group"><a href="<?php echo url_for('/page/edit?id='.$Page->getId()) ?>" class="button confirm icon edit"><?php echo __('Edit') ?></a>
      <?php else: ?>
      <div class="float_r">
      <?php endif; ?>
          <?php 
            if ($isFan) {
              echo '<a href="'.url_for('/page/unfan?id='.$Page->getId()).'" class="button confirm icon favorite">'.__('Remove you from fans').'</a>';
            } else {
              echo '<a href="'.url_for('/page/fan?id='.$Page->getId()).'" class="button confirm icon favorite">'.__('Become a fan').'</a>';
            }
          ?>
      </div>
      <div class="cleaner"></div>
      <br />
      <div>
        <div class="float_r"><img src="/uploads/pages/<?php echo $Page->getPhoto() ?>" alt="<?php echo $Page->getTitle() ?>" class="pic_big" /></div>
        <div class="cleaner"></div>
      </div>
      <br />
      <div><?php echo $Page->getDescription() ?></div>
      <br />
      <h2><?php echo __('Fans') ?></h2>
<?php if ($fans->getResults()->count() > 0): ?>
<?php $fannedUsers = 0; ?>
<?php foreach ($fans->getResults() as $fan): ?>
<?php $sfGuardUserProfile = $fan->getsfGuardUserProfile(); ?>
<?php $canSee = ($sfGuardUserProfile->getPagesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($sfGuardUserProfile->getPagesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $sfGuardUserProfile->isFriendOfFriends($user)) || ($sfGuardUserProfile->getPagesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $sfGuardUserProfile->isFriend($user)); ?>
  <?php if ($isOwner || $canSee || $user->getId() == $sfGuardUserProfile->getId()): ?>
    <?php $fannedUsers++; ?>
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$sfGuardUserProfile->getId()) ?>"><img src="<?php if ($sfGuardUserProfile->getPhoto()) { echo '/uploads/profiles/small-'.$sfGuardUserProfile->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?>" class="small" /></a>
          </div>
          <div class="float_l msg-text-buttons"><a href="<?php echo url_for('profile/show?id='.$sfGuardUserProfile->getId()) ?>"><?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?></a></div>
          <div class="cleaner"></div>
        </div>
  <?php endif; ?>
<?php endforeach; ?>
  <?php if ($fannedUsers == 0): ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
      <br />
  <?php else: ?>
  <div class="cleaner"></div>
  <br />
    <?php if($fans->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('/page/show?id='.$Page->getId()) ?>&page=<?php echo $fans->getPreviousPage() ?>" class="button confirm"><</a>
      <?php foreach ($fans->getLinks() as $p): ?>
        <?php if ($p == $fans->getPage()): ?>
        <a href="<?php echo url_for('/page/show?id='.$Page->getId()) ?>&page=<?php echo $p ?>" class="button"><?php echo $p ?></a>
        <?php else: ?>
        <a href="<?php echo url_for('/page/show?id='.$Page->getId()) ?>&page=<?php echo $p ?>" class="button confirm"><?php echo $p ?></a>
        <?php endif; ?>
      <?php endforeach; ?>
    <a href="<?php echo url_for('/page/show?id='.$Page->getId()) ?>&page=<?php echo $fans->getNextPage() ?>" class="button confirm">></a>
  </div>
  <br />
    <?php endif; ?> 
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('This page has no fans ;-(') ?></div>
      <br />
<?php endif; ?>
      <br />
    </section>
    <div class="cleaner"></div>
    <br />

