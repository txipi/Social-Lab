<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <!--[if IE]><script src="/js/html5.js"></script><![endif]-->
  </head>
  <body>
  <div id="wrapper">
    <?php include_partial('profile/nav') ?>
    <section id="main">
      <?php echo $sf_content ?>
    </section>
    <footer>
      <section id="footer-area">
        <section id="footer-outer-block">
          <aside class="footer-segment">
            <h4><?php echo link_to('Social Lab', '@homepage') ?></h4>
              <ul>
                <li><?php echo link_to(__('What is Social Lab?'), 'default/social') ?></li>
                <li><?php echo link_to(__('Terms of Use'), 'default/tos') ?></li>
                <li><?php echo link_to(__('About'), 'default/about') ?></li>
              </ul>
          </aside>
        </section>
      </section>
    </footer>
  </div>
  </body>
</html>

