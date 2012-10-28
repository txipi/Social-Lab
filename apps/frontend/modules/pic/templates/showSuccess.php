    <?php include_partial('profile/aside') ?>
    <section id="content">
      <div class="float_l"><h2><?php echo $Picture->getTitle() ?></h2></div>
      <?php if ($isOwner): ?>
      <div class="float_r"><a href="<?php echo url_for('/pic/edit?id='.$Picture->getId()) ?>" class="button confirm icon edit"><?php echo __('Edit') ?></a></div>
      <?php endif; ?>
      <div class="cleaner"></div>
      <br />
      <div>
        <div class="float_r"><img src="/uploads/pics/<?php echo $Picture->getPhoto() ?>" alt="<?php echo $Picture->getTitle() ?>" class="pic_big" /></div>
        <div class="cleaner"></div>
      </div>
      <br />
      <h2><?php echo __('Tagged friends') ?></h2>
<?php if ($tags->getResults()->count() > 0): ?>
<?php $taggedFriends = 0; ?>
<?php foreach ($tags->getResults() as $tag): ?>
  <?php $sfGuardUserProfile = $tag->getsfGuardUserProfile(); ?>
  <?php $canSee = ($sfGuardUserProfile->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_public')) || ($sfGuardUserProfile->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_fof') && $sfGuardUserProfile->isFriendOfFriends($user)) || ($sfGuardUserProfile->getPicturesInfoIsPublic() == sfConfig::get('app_privacy_friends') && $sfGuardUserProfile->isFriend($user)); ?>
  <?php if ($isOwner || $canSee || $user->getId() == $sfGuardUserProfile->getId()): ?>
    <?php $taggedFriends++; ?>
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$sfGuardUserProfile->getId()) ?>"><img src="<?php if ($sfGuardUserProfile->getPhoto()) { echo '/uploads/profiles/small-'.$sfGuardUserProfile->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?>" class="small" /></a>
          </div>
          <div class="float_r">
        <?php if ($isOwner || $user->getId() == $tag->getUserId()): ?>
        <div><a href="<?php echo url_for('pic/untag?id='.$Picture->getId().'&user='.$sfGuardUserProfile->getId()) ?>" class="button confirm icon tag"><?php echo __('Untag') ?></a></div>
        <?php endif; ?>
          </div>
          <div class="float_l msg-text-buttons"><a href="<?php echo url_for('profile/show?id='.$sfGuardUserProfile->getId()) ?>"><?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?></a></div>
          <div class="cleaner"></div>
        </div>
  <?php endif; ?>
<?php endforeach; ?>
  <?php if ($taggedFriends == 0): ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
      <br />
  <?php else: ?>
  <div class="cleaner"></div>
  <br />
    <?php if($tags->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('/pic/show?id='.$Picture->getId()) ?>&page=<?php echo $tags->getPreviousPage() ?>" class="button confirm"><</a>
      <?php foreach ($tags->getLinks() as $page): ?>
        <?php if ($page == $tags->getPage()): ?>
        <a href="<?php echo url_for('/pic/show?id='.$Picture->getId()) ?>&page=<?php echo $page ?>" class="button"><?php echo $page ?></a>
        <?php else: ?>
        <a href="<?php echo url_for('/pic/show?id='.$Picture->getId()) ?>&page=<?php echo $page ?>" class="button confirm"><?php echo $page ?></a>
        <?php endif; ?>
      <?php endforeach; ?>
    <a href="<?php echo url_for('/pic/show?id='.$Picture->getId()) ?>&page=<?php echo $tags->getNextPage() ?>" class="button confirm">></a>
  </div>
  <br />
    <?php endif; ?> 
  <?php endif; ?>
<?php else: ?>
      <div class="fbinfobox"><?php echo __('This picture has no tags ;-(') ?></div>
      <br />
<?php endif; ?>
<?php if ($isOwner): ?>
      <h3><?php echo __('Tag a friend') ?></h3>
<?php include_partial('tag/form', array('form' => $form)) ?>
<?php endif; ?>
    </section>
    <div class="cleaner"></div>
    <br />


