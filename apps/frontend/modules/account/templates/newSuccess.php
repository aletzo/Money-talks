<?php use_helper('I18N') ?>

<form method="post" action="<?php echo url_for('@account_new') ?>" class="form-horizontal">
    <fieldset>
        <div class="control-group">
            <label class="control-label"><?php echo __('Name') ?></label>
            <div class="controls">
                <input name="name" class="large" type="text" />
            </div>
        </div>
        <div class="form-actions">
            <input name="submit" class="btn btn-primary" type="submit" value="<?php echo __('Create') ?>" />
        </div>
    </fieldset>
</form>
