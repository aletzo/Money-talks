<?php use_helper('I18N') ?>
<?php use_javascript('autocomplete-tags', 'last') ?>

<script type="text/javascript">
    var availableTags = <?php echo html_entity_decode($available_tags) ?>;
</script>

<form method="post" action="<?php echo url_for('@action_new') ?>" class="form-horizontal">
    <fieldset>
        <div class="control-group">
            <label class="control-label"><?php echo __('Name') ?></label>
            <div class="controls">
                <input name="name" class="span6" type="text" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo __('Date') ?></label>
            <div class="controls">
                <input name="date" class="span2 datepicker" type="text" />
                <span class="help-inline">YYYY-MM-DD (e.g. 2011-12-30)</span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo __('Deposit') ?></label>
            <div class="controls">
                <input name="deposit" class="span2" type="text" />
                <span class="help-inline"><?php echo __('Use a period "." for decimal separator (e.g. 42.5 for forty-two point five)') ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo __('Withdrawal') ?></label>
            <div class="controls">
                <input name="withdrawal" class="span2" type="text" />
                <span class="help-inline"><?php echo __('Use a period "." for decimal separator (e.g. 42.5 for forty-two point five)') ?></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo __('Tags') ?></label>
            <div class="controls">
                <input name="tags" class="span5" type="text" id="tags" />
                <span class="help-inline"><?php echo __('Use the comma as delimeter (e.g. Home, Rent, Athens)') ?></span>
            </div>
        </div>
        <div class="form-actions">
            <input name="submit" class="btn btn-primary" type="submit" value="<?php echo __('Create') ?>" />
        </div>
    </fieldset>
</form>
