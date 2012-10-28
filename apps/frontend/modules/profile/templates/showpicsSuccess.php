    <?php include_partial('profile/showaside', array("sfGuardUserProfile" => $sfGuardUserProfile)) ?>
    <section id="content">
      <h2><?php echo __('Pictures of %user%', array('%user%' => $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName())) ?></h2>
<?php if ($picturesInfo && $pics->getResults()->count() > 0): ?>
<?php foreach ($pics->getResults() as $pic): ?>
        <div class="fbgreybox">
          <div class="float_l">
          <a href="<?php echo url_for('pic/show?id='.$pic->getId()) ?>"><img src="<?php echo '/uploads/pics/small-'.$pic->getPhoto() ?>" alt="<?php echo $pic->getTitle() ?>" class="pic_small" /></a><br />
          </div>
          <div class="float_l msg-text-buttons"><a href="<?php echo url_for('pic/show?id='.$pic->getId()) ?>"><?php echo $pic->getTitle() ?><br /></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <div class="cleaner"></div>
  <br />
  <?php if($pics->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $pics->getPreviousPage() ?>&pagetag=<?php echo $tags->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($pics->getLinks() as $page): ?>
      <?php if ($page == $pics->getPage()): ?>
        <a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $page ?>&pagetag=<?php echo $tags->getPage() ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $page ?>&pagetag=<?php echo $tags->getPage() ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $pics->getNextPage() ?>&pagetag=<?php echo $tags->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
      <br />
<?php endif; ?>
      <div class="cleaner"></div>
      <br />
      <br />
      <h2><?php echo __('%user% has been tagged in these pictures', array('%user%' => $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName())) ?></h2>
<?php if ($picturesInfo && $tags->getResults()->count() > 0): ?>
<?php foreach ($tags->getResults() as $tag): ?>
<?php $pic = PicturePeer::retrieveByPk($tag->getPictureId());?>
        <div class="fbgreybox">
          <div class="float_l">
          <a href="<?php echo url_for('pic/show?id='.$pic->getId()) ?>"><img src="<?php echo '/uploads/pics/small-'.$pic->getPhoto() ?>" alt="<?php echo $pic->getTitle() ?>" class="pic_small" /></a><br />
          </div>
          <div class="float_l msg-text-buttons"><a href="<?php echo url_for('pic/show?id='.$pic->getId()) ?>"><?php echo $pic->getTitle() ?><br /></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <div class="cleaner"></div>
  <br />
  <?php if($tags->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>?pagetag=<?php echo $tags->getPreviousPage() ?>&page=<?php echo $pics->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($tags->getLinks() as $page): ?>
      <?php if ($page == $tags->getPage()): ?>
        <a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>?pagetag=<?php echo $page ?>&page=<?php echo $pics->getPage() ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>?pagetag=<?php echo $page ?>&page=<?php echo $pics->getPage() ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>?pagetag=<?php echo $tags->getNextPage() ?>&page=<?php echo $pics->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
      <br />
<?php endif; ?>
      <div class="cleaner"></div>
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

