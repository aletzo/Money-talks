<?php use_helper('I18N') ?>
<?php use_javascript('autocomplete-tags', 'last') ?>

<script type="text/javascript">
    var availableTags = <?php echo html_entity_decode($available_tags) ?>;
</script>

<form method="post" action="<?php echo url_for('@budget_new') ?>">
    <fieldset>
        <div class="clearfix">
            <label><?php echo __('Limit') ?></label>
            <div class="input">
                <input name="amount" class="large" type="text" />
            </div>
        </div>
        <div class="clearfix">
            <label><?php echo __('Tags') ?></label>
            <div class="input">
                <input name="tags" class="span5" type="text" id="tags" />
                <span class="help-inline"><?php echo __('Use the comma as delimeter (e.g. Home, Rent, Athens)') ?></span>
            </div>
        </div>
        <div class="clearfix">
            <input name="submit" class="btn primary" type="submit" value="<?php echo __('Create') ?>" />
        </div>
    </fieldset>
</form>
