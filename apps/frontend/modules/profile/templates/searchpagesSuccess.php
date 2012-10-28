    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Search pages') ?></h2>
<?php if ($pages->getResults()->count() > 0): ?>
<?php foreach ($pages->getResults() as $page): ?>
<?php     
  $criteria = new Criteria();
  $criteria->add(FanPeer::PAGE_ID, $page->getId());
  $isFan = ($sfGuardUserProfile->countFans($criteria) > 0);
?>
        <div class="fbgreybox">
          <div class="float_l">
          <a href="<?php echo url_for('page/show?id='.$page->getId()) ?>"><img src="<?php echo '/uploads/pages/small-'.$page->getPhoto() ?>" alt="<?php echo $page->getTitle() ?>" class="pic_small" /></a><br />
          </div>
          <div class="float_r">
          <?php 
            if ($isFan) {
              echo '<a href="'.url_for('/page/unfan?id='.$page->getId()).'" class="button confirm icon favorite">'.__('Remove you from fans').'</a>';
            } else {
              echo '<a href="'.url_for('/page/fan?id='.$page->getId()).'" class="button confirm icon favorite">'.__('Become a fan').'</a>';
            }
          ?>
          </div>
          <div class="float_l msg-pic-big-buttons"><a href="<?php echo url_for('page/show?id='.$page->getId()) ?>"><?php echo $page->getTitle() ?><br /></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <div class="cleaner"></div>
  <br />
  <?php if($pages->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/searchpages') ?>?page=<?php echo $pages->getPreviousPage() ?>" class="button confirm"><</a>
    <?php foreach ($pages->getLinks() as $p): ?>
      <?php if ($p == $pages->getPage()): ?>
        <a href="<?php echo url_for('profile/searchpages') ?>?page=<?php echo $p ?>" class="button"><?php echo $p ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/searchpages') ?>?page=<?php echo $p ?>" class="button confirm"><?php echo $p ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/searchpages') ?>?page=<?php echo $pages->getNextPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('There are no pages available ;-(') ?></div>
      <br />
<?php endif; ?>
      <div class="cleaner"></div>
      <br />
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

