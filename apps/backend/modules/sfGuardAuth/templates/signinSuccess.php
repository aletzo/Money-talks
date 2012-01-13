<?php use_helper('I18N') ?>
<h2><?php echo __('Log in') ?></h2>
<?php if ($form['username']->hasError()) : ?>
    <div class="alert error clearfix">
        <?php echo $form['username']->renderError() ?>
    </div>
<?php endif ?>
<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
    <?php echo $form->renderHiddenFields() ?>
    <div class="clearfix">
        <label for="username"><?php echo $form['username']->renderLabelName() ?></label>
        <div class="input"><?php echo $form['username'] ?></div>
    </div>
    <div class="clearfix">
        <label for="password"><?php echo $form['password']->renderLabelName() ?></label>
        <div class="input"><?php echo $form['password'] ?></div>
    </div>
    <div class="actions">
        <input class="btn primary" type="submit" value="<?php echo __('Log in') ?>" />
    </div>
</form>
