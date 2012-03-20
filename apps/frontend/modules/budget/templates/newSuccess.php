<?php use_helper('I18N') ?>
<?php use_javascript('autocomplete-tags', 'last') ?>

<script type="text/javascript">
    var availableTags = <?php echo html_entity_decode($available_tags) ?>;
</script>

<form method="post" action="<?php echo url_for('@budget_new') ?>" class="form-horizontal">
    <fieldset>
        <div class="control-group">
            <label class="control-label"><?php echo __('Amount') ?></label>
            <div class="controls">
                <input name="amount" class="large" type="text" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo __('Tags') ?></label>
            <div class="controls">
                <input name="tags" class="span5" type="text" id="tags" />
                <span class="help-inline"><?php echo __('Use the comma as delimeter (e.g. Home, Rent, Athens)') ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo __('Combine tags') ?></label>
            <div class="controls">
                <label class="radio">
                    <input type="radio" checked="checked" value="or" name="tags_combined">
                    <b><?php echo __('OR') ?></b>: <?php echo __('Combine tags with <b>or</b> to find actions that have any of the tags (e.g. "Food <b>or</b> Beverages")') ?>
                </label>
                <label class="radio">
                    <input type="radio" checked="checked" value="and" name="tags_combined">
                    <b><?php echo __('AND') ?></b>: <?php echo __('Combine tags with <b>and</b> to find actions that have all the tags (e.g. "Food <b>and</b> Beverages")') ?>
                </label>
            </div>
        </div>
        <div class="form-actions">
            <input name="submit" class="btn btn-primary" type="submit" value="<?php echo __('Create') ?>" />
        </div>
    </fieldset>
</form>
