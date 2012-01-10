<?php use_helper('I18N') ?>
<?php use_javascript('autocomplete-tags', 'last') ?>

<script type="text/javascript">
    var availableTags = <?php echo html_entity_decode($available_tags) ?>;
</script>

<form method="post" action="<?php echo url_for('@action_new') ?>">
    <fieldset>
        <div class="clearfix">
            <label><?php echo __('Name') ?></label>
            <div class="input">
                <input name="name" class="span6" type="text" />
            </div>
        </div>
        <div class="clearfix">
            <label><?php echo __('Date') ?></label>
            <div class="input">
                <input name="date" class="span2 datepicker" type="text" />
                <span class="help-inline">YYYY-MM-DD (e.g. 2011-12-30)</span>
            </div>
        </div>
        <div class="clearfix">
            <label><?php echo __('Deposit') ?></label>
            <div class="input">
                <input name="deposit" class="span2" type="text" />
                <span class="help-inline"><?php echo __('Use a period "." for decimal separator') ?></span>
            </div>
        </div>
        <div class="clearfix">
            <label><?php echo __('Withdrawal') ?></label>
            <div class="input">
                <input name="withdrawal" class="span2" type="text" />
                <span class="help-inline"><?php echo __('Use a period "." for decimal separator') ?></span>
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
