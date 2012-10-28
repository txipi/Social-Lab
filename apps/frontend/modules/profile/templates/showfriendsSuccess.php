    <?php include_partial('profile/showaside', array("sfGuardUserProfile" => $sfGuardUserProfile)) ?>
    <section id="content">
      <h2><?php echo __('Friends of %user%', array('%user%' => $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName())) ?></h2>
<?php if ($friendsInfo && $sfGuardUserProfiles->getResults()->count() > 0): ?>
<?php foreach ($sfGuardUserProfiles->getResults() as $profile): ?>
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$profile->getId()) ?>"><img src="<?php if ($profile->getPhoto()) { echo '/uploads/profiles/small-'.$profile->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $profile->getFirstName().' '.$profile->getLastName() ?>" class="small" /></a>
          </div>
          <?php if ($user->getId() != $profile->getId()): ?>
          <div class="float_r">
          <?php if (in_array($user->getId(), $profile->getFriendsId(false)->getRawValue())): ?>
            <?php echo link_to(__('Block friend'), 'profile/block?id='.$profile->getId(), array('class' => 'button confirm icon remove', 'confirm' => __('Are you sure?'))) ?>
          <?php else: ?>
            <?php echo link_to(__('Add friend'), 'profile/request?id='.$profile->getId(), array('class' => 'button confirm icon approve')) ?>
          <?php endif; ?>
          </div>
          <?php endif; ?>
          <div class="float_l msg-text-big-buttons"><a href="<?php echo url_for('profile/show?id='.$profile->getId()) ?>"><?php echo $profile->getFirstName().' '.$profile->getLastName() ?></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <?php if($sfGuardUserProfiles->haveToPaginate()): ?>
      <div class="cleaner"></div>
      <br />
  <div class="pagination center">
    <a href="<?php echo url_for('profile/showfriends?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $sfGuardUserProfiles->getPreviousPage() ?>" class="button confirm"><</a>
    <?php foreach ($sfGuardUserProfiles->getLinks() as $page): ?>
      <?php if ($page == $sfGuardUserProfiles->getPage()): ?>
        <a href="<?php echo url_for('profile/showfriends?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $page ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/showfriends?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $page ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/showfriends?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $sfGuardUserProfiles->getNextPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
      <div class="cleaner"></div>
      <br />
<?php else: ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
<?php endif; ?>
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

