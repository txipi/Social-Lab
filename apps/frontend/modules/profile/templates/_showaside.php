    <aside id="sidebar">
      <a href="<?php echo url_for('profile/show?id='.$sfGuardUserProfile->getId()) ?>"><img src="<?php if ($sfGuardUserProfile->getPhoto()) { echo '/uploads/profiles/'.$sfGuardUserProfile->getPhoto(); } else { echo "/images/user.jpg"; } ?>" alt="<?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?>" class="big" /></a><br /><br />
      <ul>
        <li><a href="<?php echo url_for('profile/show?id='.$sfGuardUserProfile->getId()) ?>" class="button aside icon home"><?php echo __('Wall') ?></a></li>
        <li><a href="<?php echo url_for('profile/showprofile?id='.$sfGuardUserProfile->getId()) ?>" class="button aside icon home"><?php echo __('View profile') ?></a></li>
        <li><a href="<?php echo url_for('profile/showfriends?id='.$sfGuardUserProfile->getId()) ?>" class="button aside icon user"><div class="float_l"><?php echo __('Friends') ?></div><div class="float_r">(<?php echo $sfGuardUserProfile->getFriendsId(false)->count() ?>)</div></a></li>
        <li><a href="<?php echo url_for('profile/showpics?id='.$sfGuardUserProfile->getId()) ?>" class="button aside icon tag"><?php echo __('Pictures') ?></a></li>
        <li><a href="<?php echo url_for('profile/showpages?id='.$sfGuardUserProfile->getId()) ?>" class="button aside icon favorite"><?php echo __('Pages') ?></a></li>
      </ul>
    </aside>

