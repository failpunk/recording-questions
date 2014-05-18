<li>

    <p class="date1">Platform:</p>

    <p style="margin-left:7px;">

        <span><?php echo strtoupper($user->getPlatform()) ?></span>

        <?php if($user->getId() == $sf_context->getUser()->getCurrentUser()->getId()): ?>
            <a id="user-studio-platform-change" href="#">change</a>

            <?php echo select_tag('user-studio-platform-select', options_for_select(array(
              'pc'    => 'PC',
              'mac' => 'Mac',
              'analog' => 'Analog'
            ), $user->getPlatform()), array('style' => 'display:none;')) ?>
            <a id="user-studio-platform-cancel" href="#" style="display:none;">cancel</a>
            <span  style="display:none;" class="ajax-loader"><img src="/images/ajax-loader.gif" alt="Ajax-loader"/></span>
            <?php echo input_hidden_tag('user-studio-platform-select-route', url_for('@profile_edit_platform')) ?>
        <?php endif ?>

    </p>

</li>