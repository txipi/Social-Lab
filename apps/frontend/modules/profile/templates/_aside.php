    <aside id="sidebar">
<?php if ($sf_user->isAuthenticated()): 
  $sfGuardUserProfile = $sf_user->getProfile();
?>
      <a href="<?php echo url_for('profile/view') ?>"><img src="<?php if ($sfGuardUserProfile->getPhoto()) { echo '/uploads/profiles/'.$sfGuardUserProfile->getPhoto(); } else { echo "/images/user.jpg"; } ?>" alt="<?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?>" class="big" /></a><br /><br />
      <ul>
        <li><a href="<?php echo url_for('profile/wall') ?>" class="button aside icon log"><?php echo __('Wall') ?></a></li>
        <li><a href="<?php echo url_for('profile/view') ?>" class="button aside icon home"><?php echo __('View profile') ?></a></li>
        <li><a href="<?php echo url_for('profile/edit') ?>" class="button aside icon edit"><?php echo __('Edit profile') ?></a></li>
        <li><a href="<?php echo url_for('profile/requests') ?>" class="button aside icon loop"><div class="float_l"><?php echo __('Requests') ?></div><div class="float_r">(<?php 
           $criteria = new Criteria();
           $criteria->add(RequestPeer::STATUS, sfConfig::get('app_status_pending'));
           echo $sfGuardUserProfile->getRequestsRelatedByFromId($criteria)->count()."/"; 
           echo $sfGuardUserProfile->getRequestsRelatedByToId($criteria)->count();
        ?>)</div></a></li>
        <li><a href="<?php echo url_for('profile/messages') ?>" class="button aside icon chat"><div class="float_l"><?php echo __('Messages') ?></div><div class="float_r">(<?php 
           $criteria = new Criteria();
           $criteria->add(MessagePeer::IS_PUBLIC, false);    
           $criteria->add(MessagePeer::IS_UNREAD, true);    
           echo $sfGuardUserProfile->getMessagesRelatedByFromId($criteria)->count().'/'; 
           echo $sfGuardUserProfile->getMessagesRelatedByToId($criteria)->count();
        ?>)</div></a></li>
        <li><a href="<?php echo url_for('profile/friends') ?>" class="button aside icon user"><div class="float_l"><?php echo __('Friends') ?></div><div class="float_r">(<?php echo $sfGuardUserProfile->getFriendsProfiles()->count() ?>)</div></a></li>
        <li><a href="<?php echo url_for('profile/searchfriends') ?>" class="button aside icon search"><?php echo __('Search friends') ?></a></li>
        <li><a href="<?php echo url_for('profile/pics') ?>" class="button aside icon tag"><?php echo __('Pictures') ?></a></li>
        <li><a href="<?php echo url_for('profile/pages') ?>" class="button aside icon favorite"><?php echo __('Pages') ?></a></li>
      </ul>
<?php else: ?>
      <ul>
        <li><a href="<?php echo url_for('@signin') ?>" class="button aside icon lock"><?php echo __('Sign in') ?></a></li>
<?php if (sfConfig::get('app_signup_enabled')): ?> 
        <li><a href="<?php echo url_for('@signup') ?>" class="button aside icon key"><?php echo __('Sign up') ?></a></li>
<?php endif ?>
        <li><a href="<?php echo url_for('default/social') ?>" class="button aside icon home"><?php echo __('What is Social Lab?') ?></a></li>
        <li><a href="<?php echo url_for('default/tos') ?>" class="button aside icon settings"><?php echo __('Terms of Use') ?></a></li>
        <li><a href="<?php echo url_for('default/about') ?>" class="button aside icon mail"><?php echo __('About') ?></a></li>
      </ul>
<?php endif ?>
    </aside>

