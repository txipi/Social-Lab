    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('Your pages') ?></h2>
<?php if ($pages->getResults()->count() > 0): ?>
<?php foreach ($pages->getResults() as $page): ?>
        <div class="fbgreybox">
          <div class="float_l">
          <a href="<?php echo url_for('page/show?id='.$page->getId()) ?>"><img src="<?php echo '/uploads/pages/small-'.$page->getPhoto() ?>" alt="<?php echo $page->getTitle() ?>" class="pic_small" /></a><br />
          </div>
          <div class="float_r">
          <div><a href="<?php echo url_for('page/edit?id='.$page->getId()) ?>" class="button confirm icon edit"><?php echo __('Edit') ?></a></div>
          </div>
          <div class="float_l msg-pic-buttons"><a href="<?php echo url_for('page/show?id='.$page->getId()) ?>"><?php echo $page->getTitle() ?><br /></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <div class="cleaner"></div>
  <br />
  <?php if($pages->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/pages') ?>?page=<?php echo $pages->getPreviousPage() ?>&pagefan=<?php echo $fans->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($pages->getLinks() as $p): ?>
      <?php if ($p == $pages->getPage()): ?>
        <a href="<?php echo url_for('profile/pages') ?>?page=<?php echo $p ?>&pagefan=<?php echo $fans->getPage() ?>" class="button"><?php echo $p ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/pages') ?>?page=<?php echo $p ?>&pagefan=<?php echo $fans->getPage() ?>" class="button confirm"><?php echo $p ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/pages') ?>?page=<?php echo $pages->getNextPage() ?>&pagefan=<?php echo $fans->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('You own no pages ;-(') ?></div>
      <br />
<?php endif; ?>
      <div class="cleaner"></div>
      <br />
      <div class="float_r"><a href="<?php echo url_for('page/new') ?>" class="button confirm icon add"><?php echo __('Create a new page') ?></a></div>
      <br />
      <br />
      <br />
      <h2><?php echo __('Your favorite pages') ?></h2>
<?php if ($fans->getResults()->count() > 0): ?>
<?php foreach ($fans->getResults() as $fan): ?>
<?php $page = PagePeer::retrieveByPk($fan->getPageId());?>
        <div class="fbgreybox">
          <div class="float_l">
          <a href="<?php echo url_for('page/show?id='.$page->getId()) ?>"><img src="<?php echo '/uploads/pages/small-'.$page->getPhoto() ?>" alt="<?php echo $page->getTitle() ?>" class="pic_small" /></a><br />
          </div>
          <div class="float_r">
          <div><a href="<?php echo url_for('page/unfan?id='.$page->getId()) ?>" class="button confirm icon favorite"><?php echo __('Remove you from fans') ?></a></div>
          </div>
          <div class="float_l msg-pic-big-buttons"><a href="<?php echo url_for('page/show?id='.$page->getId()) ?>"><?php echo $page->getTitle() ?><br /></a></div>
          <div class="cleaner"></div>
        </div>
<?php endforeach; ?>
  <div class="cleaner"></div>
  <br />
  <?php if($fans->haveToPaginate()): ?>
  <div class="pagination center">
    <a href="<?php echo url_for('profile/pages') ?>?pagefan=<?php echo $fans->getPreviousPage() ?>&page=<?php echo $pages->getPage() ?>" class="button confirm"><</a>
    <?php foreach ($fans->getLinks() as $p): ?>
      <?php if ($p == $fans->getPage()): ?>
        <a href="<?php echo url_for('profile/pages') ?>?pagefan=<?php echo $p ?>&page=<?php echo $pages->getPage() ?>" class="button"><?php echo $p ?></a>
      <?php else: ?>
        <a href="<?php echo url_for('profile/pages') ?>?pagefan=<?php echo $p ?>&page=<?php echo $pages->getPage() ?>" class="button confirm"><?php echo $p ?></a>
      <?php endif; ?>
    <?php endforeach; ?>
    <a href="<?php echo url_for('profile/pages') ?>?pagefan=<?php echo $fans->getNextPage() ?>&page=<?php echo $pages->getPage() ?>" class="button confirm">></a>
  </div>
  <br />
  <?php endif; ?> 
<?php else: ?>
      <div class="fbinfobox"><?php echo __('You like no pages ;-(') ?></div>
      <br />
<?php endif; ?>
      <div class="cleaner"></div>
      <br />
      <div class="float_r"><a href="<?php echo url_for('profile/searchpages') ?>" class="button confirm icon search"><?php echo __('Search pages') ?></a></div>
      <div class="cleaner"></div>
      <br />
    <br />
    </section>
    <div class="cleaner"></div>
    <br />

