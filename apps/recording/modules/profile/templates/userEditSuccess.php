<?php use_helper('Form', 'Gravatar', 'jQuery'); ?>

		<div id="content">

			<div id="main">

				<h1 class="title"><strong>Modify Your Account Information</strong></h1>

				<p class="avatar1"><?php echo gravatar_image_tag($currentUser->getEmail())?><span><a href="http://www.gravatar.com" target="_blank">Change Picture</a></span></p>

                <?php echo form_tag('profile/userEdit', array("id" => "accountSet")) ?>

					<ul class="fieldset">

						<li class="field">
							<label>Display Name:</label>
							<?php echo $form['display_name']->render() ?>
						</li>

						<li class="field">
							<label>Email:</label>
              <?php echo $form['email']->render() ?>
							<span>we never display your email, used for notifications and gravatar image</span>
						</li>
            <?php if(!isset($is_new_user)): ?>
						<li class="field">
							<label>Real Name:</label>
							<?php echo $form['real_name']->render() ?>
						</li>

						<li class="field">
							<label>Website:</label>
                            <?php if($form['webpage']->getValue() == ''): ?>
                                <?php echo $form['webpage']->render(array('value' => 'http://')) ?>
                            <?php else: ?>
                                <?php echo $form['webpage']->render() ?>
                            <?php endif ?>
						</li>

						<li class="field">
							<label>City:</label>
							<?php echo $form['location']->render() ?>
						</li>

						<li class="field">
							<label>Country:</label>
							<?php echo jq_input_auto_complete_tag('country', $form['country']->getValue(),
								    'profile/autocompleteCountry',
		                             array(
								         'autocomplete' => 'off',
								         'type' => 'text',
								         'class' => 'text',
                                         'name' => 'user[country]'
								         ),
								         array(
										     'use_style'         => true,
								             'multiple'          => false
	                                     )
	                                 ) ?>
						</li

                        <li class="field">
							<label>Postal Code:</label>
							<?php echo $form['postal_code']->render() ?>
						</li>

						<li class="field date">

							<label>Birthday:</label>
							<?php //echo $form['birthday']->render() ?>
							<?php $date = $form['birthday']->getValue() ?>

							<?php if(!$form['birthday']->renderError() && strtotime($date)): ?>
							     <?php echo input_tag("user[birthday]", date("m/d/Y", strtotime($date)), array('class' => 'text')) ?>
							<?php else: ?>
							     <?php echo input_tag("user[birthday]", "", array('class' => 'text')) ?>
							<?php endif; ?>
							<span class="date2">MM/DD/YYYY</span>
							<span>never displayed, used to show age</span>

						</li>

						<li class="field">
							<label>About Me:</label>
							<?php echo $form['info']->render() ?>
						</li>
              <?php endif ?>
					</ul>
					   <?php if(isset($identifier)): ?>
					       <?php echo input_hidden_tag("identifier", $identifier) ?>
					   <?php endif; ?>
					<p class="submit">
						<input type="submit" class="submit" value="Save changes" />
					</p>

          <?php if($form->isBound()): ?>
            <div class="popup one profile-error">
              <p>Whoops, time to fix a few errors in your profile:</p>

                <?php foreach($form as $name => $error): ?>
                  <?php if($error->hasError()): ?>
                    <?php if($name == 'birthday'): ?>
                      <li>Double check your birthday, it must be formatted like MM/DD/YYYY</li>
                    <?php else: ?>
                      <?php echo $error->renderError() ?>
                    <?php endif ?>
                  <?php endif ?>
                <?php endforeach ?>
            </div>
          <?php endif ?>

				</form>

			</div><!-- / #main -->

			<div id="sidebar">

				<div class="wrap-box">

					<div class="box first">

						<h3>Tell Everyone About You?</h3>

						<p class="p3"><strong>Your profile information</strong> is a great way to let the community know what you're all about. We want recording questions to be a personal experience and letting your personality show is important.</p>

                        <p><strong>Your Email</strong> - will never be shared with anyone else without your permission.</p>

                        <p><strong>Profile Image</strong> - We use <a href="http://www.gravatar.com" target="_blank">Gravatar.com</a> for all our profile images. A gravatar is quite simply an image that follows you from site to site so you don't have to upload a new image every time you sign up for a new site. Gravatar uses your email address to look up your profile image and will be required to make it work.</p>

					</div><!-- .box -->

				</div><!-- .wrap-box -->

			</div><!-- / #sidebar -->

		</div><!-- / #content -->