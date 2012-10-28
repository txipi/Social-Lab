<?php use_helper('Date') ?>
    <?php include_partial('profile/showaside', array("sfGuardUserProfile" => $sfGuardUserProfile)) ?>
    <section id="content">
      <div class="float_l"><h2><?php echo $sfGuardUserProfile->getFirstName().' '.$sfGuardUserProfile->getLastName() ?></h2></div>
      <div class="float_r">
      <?php if ($isFriend): ?>
        <?php echo link_to(__('Block friend'), 'profile/block?id='.$sfGuardUserProfile->getId(), array('class' => 'button confirm icon remove', 'confirm' => __('Are you sure?'))) ?>
      <?php else: ?>
        <?php echo link_to(__('Add friend'), 'profile/request?id='.$sfGuardUserProfile->getId(), array('class' => 'button confirm icon approve')) ?>
      <?php endif; ?>
      </div>
      <div class="cleaner"></div>
      <h3><?php echo __('Personal information') ?></h3>
<?php if ($personalInfo): ?>
      <div class="fbbluebox">
        <div class="float_l"><?php echo __('Name') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getFirstName() ?> <?php echo $sfGuardUserProfile->getLastName() ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo __('e-mail') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getEmail() ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo __('Gender') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getGenderRelatedByGender() ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo __('Birthday') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getBirthday() ?></div>
        <div class="cleaner"></div>
      </div>
<?php else: ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
<?php endif; ?>
      <br />
      <h3><?php echo __('Location') ?></h3>
<?php if ($locationInfo): ?>
      <div class="fbbluebox">
        <div class="float_l"><?php echo __('Town') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getLocationTown() ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo __('Country') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getLocationCountry() ?></div>
        <div class="cleaner"></div>
      </div>
<?php else: ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
<?php endif; ?>
      <br />
      <h3><?php echo __('Academic information') ?></h3>
<?php if ($academicInfo): ?>
      <div class="fbbluebox">
        <div class="float_l"><?php echo __('Academic title') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getAcademicTitle() ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo __('Academic center') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getAcademicCenter() ?></div>
        <div class="cleaner"></div>
        <div class="float_l"><?php echo __('Promotion') ?>:</div>
        <div class="float_r"><?php echo $sfGuardUserProfile->getAcademicPromotion() ?></div>
        <div class="cleaner"></div>
      </div>
<?php else: ?>
      <div class="fbinfobox"><?php echo __('Information unavailable.') ?></div>
<?php endif; ?>
      <br />
      <h3><?php echo __('Recent posts...') ?></h3>
<?php if($posts->count() > 0): ?>
  <?php foreach ($posts as $Message): ?>
      <article>
        <div class="fbgreybox">
          <div class="float_l">
            <a href="<?php echo url_for('profile/show?id='.$Message->getsfGuardUserProfileRelatedByFromId()->getId()) ?>"><img src="<?php if ($Message->getsfGuardUserProfileRelatedByFromId()->getPhoto()) { echo '/uploads/profiles/small-'.$Message->getsfGuardUserProfileRelatedByFromId()->getPhoto(); } else { echo "/images/small-user.jpg"; } ?>" alt="<?php echo $Message->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Message->getsfGuardUserProfileRelatedByFromId()->getLastName() ?>" class="small" /></a><br />
          </div>
          <div class="float_l msg-text-buttons"><?php echo strip_tags(nl2br($Message->getText(ESC_RAW)), '<br/><br><a>') ?></div>
          <div class="cleaner"></div>
        </div>
        <div class="float_r">
          <?php 
            echo '<strong><a href="'.url_for('profile/show?id='.$Message->getsfGuardUserProfileRelatedByFromId()->getId()).'">'.$Message->getsfGuardUserProfileRelatedByFromId()->getFirstName().' '.$Message->getsfGuardUserProfileRelatedByFromId()->getLastName().'</a></strong> '.__('(%time% ago)', array('%time%' => distance_of_time_in_words(Social::getUnixTimestamp(), Social::getUnixTimestamp($Message->getUpdatedAt())))) 
          ?>
        </div>
        <div class="cleaner"></div>
        <br />
      </article>
  <?php endforeach; ?>
<?php else: ?>
      <article>
        <div class="fbinfobox"><?php echo __('There are <strong>no</strong> recent posts.') ?></div>
        <br />
      </article>
<?php endif; ?> 
      <br />
    <br />
    </section>
    <div class="cleaner"></div>
    <br />
