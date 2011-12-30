<?php use_helper('I18N') ?>

<form method="post" action="<?php echo url_for('@account_edit?id=' . $account->id) ?>">
    <fieldset>
        <div class="clearfix">
            <label><?php echo __('Name') ?></label>
            <div class="input">
                <input name="name" class="large" type="text" value="<?php echo $account->name ?>" />
            </div>
        </div>
        <div class="clearfix">
            <input name="submit" class="btn primary" type="submit" value="<?php echo __('Update') ?>" />
        </div>
    </fieldset>
</form>

