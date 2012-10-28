<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <?php include_stylesheets() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1>
          <a href="<?php echo url_for('@homepage') ?>">
            <img src="/images/backend/backend.jpg" alt="Backend" />
          </a>
        </h1>
      </div>
      <div id="menu">
<?php if ($sf_user->hasCredential('admin')): ?>
        <ul>
          <li>
            <?php echo link_to('User', '@sf_guard_user') ?>
          </li>
          <li>
            <?php echo link_to('Profile', '@sf_guard_user_profile') ?>
          </li>
          <li>
            <?php echo link_to('Message', '@message') ?>
          </li>
          <li>
            <?php echo link_to('Request', '@request') ?>
          </li>
          <li>
            <?php echo link_to('Friendship', '@friendship') ?>
          </li>
          <li>
            <?php echo link_to('Page', '@page') ?>
          </li>
          <li>
            <?php echo link_to('Picture', '@picture') ?>
          </li>
          <li>
            <?php echo link_to('Fan', '@fan') ?>
          </li>
          <li>
            <?php echo link_to('Tag', '@tag') ?>
          </li>
          <li>
            <?php echo link_to('Gender', '@gender') ?>
          </li>
          <li>
            <?php echo link_to('Status', '@status') ?>
          </li>
          <li>
            <?php echo link_to('Privacy', '@privacy') ?>
          </li>
          <li>
            <?php echo link_to('Bot', '@bot') ?>
          </li>
          <li>
            <?php echo link_to('Step', '@step') ?>
          </li>
          <li>
            <?php echo link_to('Command', '@command') ?>
          </li>
          <li>
            <?php echo link_to('Scheduled', '@scheduled') ?>
          </li>
          <li>
            <?php echo link_to('Automsg', '@automsg') ?>
          </li>
          <li>
            <?php echo link_to('Logout', '@sf_guard_signout') ?>
          </li>
        </ul>
<?php endif; ?>
      </div>
      <div id="content">
        <?php echo $sf_content ?>
      </div>

      <div id="footer">
        powered by <a href="http://www.symfony-project.org/">Symfony</a>
      </div>
    </div>
  </body>
</html>
