<div id="usermenu" class="pull-right">
    <?php if ($sf_user->isAuthenticated()) : ?>
        <a href="<?php echo url_for('@sf_guard_signout') ?>"><?php echo __('log out') ?></a>
    <?php else : ?>
        <a href="<?php echo url_for('@sf_guard_signin') ?>"><?php echo __('log in') ?></a>
    <?php endif ?>
</div>
