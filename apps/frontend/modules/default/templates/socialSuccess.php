    <?php include_partial('profile/aside') ?>
    <section id="content">
      <h2><?php echo __('What is Social Lab?') ?></h2>
      <p>
       <?php echo __('<strong>Social Lab</strong> is <strong>NOT</strong> a real social network. It is a <a href="#socialeng">social engineering</a> <a href="#wargame">wargame</a>.') ?>
      </p>
      <p>
       <?php echo __('<strong>Social Lab</strong> mimics the features of a basic social network (i.e., friendship requests, status updates, private messages, pictures, fan pages, etc.) to provide a &quot;<em>social sandbox</em>&quot;.') ?>
      </p>
      <p>
	<?php echo __('The purpose of the game is to <strong>learn</strong> some of the techniques used by social hackers in order to <strong>prevent</strong> this kind of attacks in real social networks.') ?>
      </p>
      <h3><?php echo __('How to play') ?></h3>
      <p>
	<ol class="about">
		<li><?php echo link_to(__('Create an account'), '@signup') ?></li>
		<li><?php echo link_to(__('Sign in'), '@signin') ?></li>
		<li><?php echo __('Wait for a message from the system explaining what is your next challenge as a social hacker ;)') ?></li>
	</ol>
      </p>
      <p>
        <?php echo __('Important tips:') ?>
	<ul class="about">
		<li><?php echo __('Every challenge will be controlled by an <strong>automated</strong> profile (no real people privacy is invaded playing <strong>Social Lab</strong>).') ?></li>
		<li><?php echo __('These profiles must be convinced to become your friends using your social engineering skills.') ?></li>
		<li><?php echo __('Their responses are automatic but <strong>not immediate</strong>. Sometimes they need a few minutes to realize that you look friendly enough to become their friend ;-)') ?></li>
	</ul>
      </p>
      <a name="socialeng" id="socialeng"></a>
      <h3><?php echo __('What is Social Engineering?') ?></h3>
      <p>
	<?php echo __('<a href="http://en.wikipedia.org/wiki/Social_engineering_%28security%29">Social engineering</a>, in the context of security, is understood to mean the art of manipulating people into performing actions or divulging confidential information. While it is similar to a confidence trick or simple fraud, it is typically trickery or deception for the purpose of information gathering, fraud, or computer system access; in most cases the attacker never comes face-to-face with the victims.') ?>
      </p>
      </p>
	<?php echo __('Social engineering as an act of psychological manipulation had previously been associated with the social sciences, but its usage has caught on among computer professionals.') ?>
      </p>
      <a name="wargame" id="wargame"></a>
      <h3><?php echo __('What is a wargame?') ?></h3>
      <p>
	<?php echo __('A <a href="http://en.wikipedia.org/wiki/Wargame_%28hacking%29">wargame in hacking</a> is a security challenge in which one must exploit a vulnerability in a system or application or gain access to a system.') ?>
      </p>
    </section>
    <br />
