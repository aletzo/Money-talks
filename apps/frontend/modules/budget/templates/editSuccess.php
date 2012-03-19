<?php use_helper('I18N') ?>

<form method="post" action="<?php echo url_for('@budget_edit?id=' . $budget->id) ?>">
    <fieldset>
        <div class="clearfix">
            <label><?php echo __('Limit') ?></label>
            <div class="input">
                <input name="amount" class="large" type="text" value="<?php echo $budget->limit ?>" />
            </div>
            <label><?php echo __('Tags') ?></label>
            <div class="input">
                <input name="tags" class="large" type="text" value="<?php echo $budget->tags ?>" />
            </div>
        </div>
        <div class="clearfix">
            <input name="submit" class="btn primary" type="submit" value="<?php echo __('Update') ?>" />
        </div>
    </fieldset>
</form>

