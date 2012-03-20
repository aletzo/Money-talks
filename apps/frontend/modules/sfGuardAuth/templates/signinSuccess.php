<?php use_helper('I18N') ?>
<h2><?php echo __('Log in') ?></h2>
<?php if ($form['username']->hasError()) : ?>
    <div class="alert error clearfix">
        <?php echo $form['username']->renderError() ?>
    </div>
<?php endif ?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post" class="form-horizontal">
    <?php echo $form->renderHiddenFields() ?>
    <div class="control-group">
        <label class="control-label" for="username"><?php echo $form['username']->renderLabelName() ?></label>
        <div class="controls"><?php echo $form['username'] ?></div>
    </div>
    <div class="control-group">
        <label class="control-label" for="password"><?php echo $form['password']->renderLabelName() ?></label>
        <div class="controls"><?php echo $form['password'] ?></div>
    </div>
    <div class="form-actions">
        <input class="btn btn-primary" type="submit" value="<?php echo __('Log in') ?>" />
        <a href="<?php echo url_for('sf_guard_register') ?>" class="btn"><?php echo __('Join now!') ?></a>
        <a href="<?php echo url_for('sfGuardForgotPassword/index') ?>" class="btn"><?php echo __('Forgot your password?') ?></a>
    </div>
</form>
<?php include_partial('openid_options') ?>
