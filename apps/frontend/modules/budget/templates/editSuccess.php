<?php use_helper('I18N') ?>
<?php use_javascript('autocomplete-tags', 'last') ?>

<script type="text/javascript">
    var availableTags = <?php echo html_entity_decode($available_tags) ?>;
</script>

<form method="post" action="<?php echo url_for('@budget_edit?id=' . $budget->id) ?>" class="form-horizontal">
    <fieldset>
        <div class="control-group">
            <label class="control-label"><?php echo __('Amount') ?></label>
            <div class="controls">
                <?php $budget_amount = $budget->fetchAmount($symmetric_key) ?>
                <input name="amount" class="large" type="text" value="<?php if ($budget_amount) echo $budget_amount ?>" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo __('Tags') ?></label>
            <div class="controls">
                <input name="tags" class="span5" type="text" id="tags" value="<?php echo $tags ?>" />
                <span class="help-inline"><?php echo __('Use the comma as delimeter (e.g. Home, Rent, Athens)') ?></span>
            </div>
        </div>
        <div class="form-actions">
            <input name="submit" class="btn btn-primary" type="submit" value="<?php echo __('Update') ?>" />
        </div>
    </fieldset>
</form>

