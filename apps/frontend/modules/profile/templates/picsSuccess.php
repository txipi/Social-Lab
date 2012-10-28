    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Your pictures') ?></h2>
<?php if ($pics->getResults()->count() > 0): ?>
<?php foreach ($pics->getResults() as $pic): ?>
        <div class="fbgreybox">
          <div class="float_l">
          <a href="<?php echo url_for('pic/show?id='.$pic->getId()) ?>"><img src="<?php echo '/uploads/pics/small-'.$pic->getPhoto() ?>" alt="<?php echo $pic->getTitle() ?>" class="pic_small" /></a><br />
          </div>
          <div class="float_r">
          <div><a href="<?php echo url_for('pic/edit?id='.$pic->getId()) ?>" class="button confirm icon edit"><?php echo __('Edit') ?></a></div>
          </div>
          <div class="float_l msg-pic-buttons"><a href="<?php echo url_for('pic/show?id='.$pic->getId()) ?>"><?php echo $pic->getTitle() ?><br /></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <div class="cleaner"></div>
  <br />
  <?php if($pics->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/pics') ?>?page=<?php echo $pics->getPreviousPage() ?>&pagetag=<?php echo $tags->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($pics->getLinks() as $page): ?>
      <?php if ($page == $pics->getPage()): ?>
        <a href="<?php echo url_for('profile/pics') ?>?page=<?php echo $page ?>&pagetag=<?php echo $tags->getPage() ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/pics') ?>?page=<?php echo $page ?>&pagetag=<?php echo $tags->getPage() ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/pics') ?>?page=<?php echo $pics->getNextPage() ?>&pagetag=<?php echo $tags->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('You have no pictures ;-(') ?></div>
      <br />
<?php endif; ?>
      <div class="cleaner"></div>
      <br />
      <div class="float_r"><a href="<?php echo url_for('pic/new') ?>" class="button confirm icon add"><?php echo __('Upload a picture') ?></a></div>
      <br />
      <br />
      <br />
      <h2><?php echo __('You have been tagged in these pictures') ?></h2>
<?php if ($tags->getResults()->count() > 0): ?>
<?php foreach ($tags->getResults() as $tag): ?>
<?php $pic = PicturePeer::retrieveByPk($tag->getPictureId());?>
        <div class="fbgreybox">
          <div class="float_l">
          <a href="<?php echo url_for('pic/show?id='.$pic->getId()) ?>"><img src="<?php echo '/uploads/pics/small-'.$pic->getPhoto() ?>" alt="<?php echo $pic->getTitle() ?>" class="pic_small" /></a><br />
          </div>
          <div class="float_r">
          <div><a href="<?php echo url_for('pic/untag?id='.$pic->getId().'&user='.$sfGuardUserProfile->getId()) ?>" class="button confirm icon tag"><?php echo __('Untag') ?></a></div>
          </div>
          <div class="float_l msg-pic-buttons"><a href="<?php echo url_for('pic/show?id='.$pic->getId()) ?>"><?php echo $pic->getTitle() ?><br /></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <div class="cleaner"></div>
  <br />
  <?php if($tags->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/pics') ?>?pagetag=<?php echo $tags->getPreviousPage() ?>&page=<?php echo $pics->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($tags->getLinks() as $page): ?>
      <?php if ($page == $tags->getPage()): ?>
        <a href="<?php echo url_for('profile/pics') ?>?pagetag=<?php echo $page ?>&page=<?php echo $pics->getPage() ?>" class="button"><?php echo $page ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/pics') ?>?pagetag=<?php echo $page ?>&page=<?php echo $pics->getPage() ?>" class="button confirm"><?php echo $page ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/pics') ?>?pagetag=<?php echo $tags->getNextPage() ?>&page=<?php echo $pics->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('You have not been tagged in any picture ;-(') ?></div>
      <br />
<?php endif; ?>
      <div class="cleaner"></div>
      <br />
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

