<?php use_helper('I18N') ?>

<form method="post" action="<?php echo url_for('@account_new') ?>">
    <fieldset>
        <div class="clearfix">
            <label><?php echo __('Name') ?></label>
            <div class="input">
                <input name="name" class="large" type="text" />
            </div>
        </div>
        <div class="clearfix">
            <input name="submit" class="btn primary" type="submit" value="<?php echo __('Create') ?>" />
        </div>
    </fieldset>
</form>
