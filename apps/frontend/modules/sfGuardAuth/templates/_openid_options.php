<p class="or"> - <?php echo __('OR') ?> - </p>
<p><?php echo __('You may also log in using an account on one of these sites. Just click on it:') ?></p>
<div class="actions">
    <form class="inline-form" method="post" action="<?php echo url_for('@openid_login') ?>">
        <input type="hidden" name="provider" value="google" />
        <input type="submit" class="btn btn-primary" value="Google" title="log in with Google" />
    </form>
    <form class="inline-form" method="post" action="<?php echo url_for('@openid_login') ?>">
        <input type="hidden" name="provider" value="yahoo" />
        <input type="submit" class="btn btn-primary" value="Yahoo" title="log in with Yahoo" />
    </form>
    <?php if (sfConfig::get('sf_environment') == 'dev') : ?>
        <form class="inline-form" method="post" action="<?php echo url_for('@openid_login') ?>">
            <input type="hidden" name="provider" value="local" />
            <input type="submit" class="btn btn-danger" value="Local" title="log in with local" />
        </form>
    <?php endif ?>
</div>
