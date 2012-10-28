    <?php include_partial('profile/showaside', array("sfGuardUserProfile" => $sfGuardUserProfile)) ?>
    <section id="content">
      <h2><?php echo __('Favourite pages of %user%', array('%user%' => $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName())) ?></h2>
<?php if ($pagesInfo && $fans->getResults()->count() > 0): ?>
<?php foreach ($fans->getResults() as $fan): ?>
<?php $page = PagePeer::retrieveByPk($fan->getPageId());?>
<?php     
  $criteria = new Criteria();
  $criteria->add(FanPeer::PAGE_ID, $page->getId());
  $isFan = ($user->countFans($criteria) > 0);
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
          <div class="float_l msg-text-buttons"><a href="<?php echo url_for('page/show?id='.$page->getId()) ?>"><?php echo $page->getTitle() ?><br /></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <div class="cleaner"></div>
  <br />
  <?php if($fans->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/showpages?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $fans->getPreviousPage() ?>" class="button confirm"><</a>
    <?php foreach ($fans->getLinks() as $p): ?>
      <?php if ($p == $fans->getPage()): ?>
        <a href="<?php echo url_for('profile/showpages?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $p ?>" class="button"><?php echo $p ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/showpages?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $p ?>" class="button confirm"><?php echo $p ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/showpages?id='.$sfGuardUserProfile->getId()) ?>?page=<?php echo $fans->getNextPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
<?php endif; ?>
    <br />
    </section>
    <div class="cleaner"></div>
    <br />
