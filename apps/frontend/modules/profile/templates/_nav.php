  <header>
<?php if ($sf_user->isAuthenticated()): ?>
    <a href="<?php echo url_for('@homepage') ?>"><img src="/images/logo.png" alt="Social Lab" class="noshadow"/></a>
<?php else: ?>
    <a href="<?php echo url_for('@signin') ?>"><img src="/images/logo.png" alt="Social Lab" class="noshadow"/></a>
<?php endif ?>
  </header>
  <nav>
    <div class="menu">
      <ul>
<?php if ($sf_user->isAuthenticated()): ?>
        <li><a href="<?php echo url_for('@homepage') ?>"><?php echo __('Wall') ?></a></li><span class="divider">|</span> 
        <li><a href="<?php echo url_for('profile/view') ?>"><?php echo __('Profile') ?></a></li><span class="divider">|</span> 
        <li><a href="<?php echo url_for('profile/friends') ?>"><?php echo __('Friends') ?></a></li><span class="divider">|</span> 
        <li><a href="<?php echo url_for('@signout') ?>"><?php echo __('Sign out') ?></a></li>
<?php else: ?>
        <li><a href="<?php echo url_for('@signin') ?>"><?php echo __('Sign in') ?></a></li>
        <li><a href="<?php echo url_for('@signup') ?>"><?php echo __('Sign up') ?></a></li>
<?php endif ?>
      </ul>
    </div>
  </nav>

