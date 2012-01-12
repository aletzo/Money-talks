<?php use_helper('I18N') ?>
<?php use_javascript('autocomplete-tags', 'last') ?>

<script type="text/javascript">
    var availableTags = <?php echo html_entity_decode($available_tags) ?>;
</script>

<form method="post" action="<?php echo url_for('@action_edit?id=' . $action->id) ?>">
    <fieldset>
        <div class="clearfix">
            <label><?php echo __('Name') ?></label>
            <div class="input">
                <input name="name" class="large" type="text" value="<?php echo $action->name ?>" />
            </div>
        </div>
        <div class="clearfix">
            <label><?php echo __('Date') ?></label>
            <div class="input">
                <input name="date" class="span2 datepicker" type="text" value="<?php echo $action->date ?>" />
                <span class="help-inline">YYYY-MM-DD (e.g. 2011-12-30)</span>
            </div>
        </div>
        <div class="clearfix">
            <label><?php echo __('Deposit') ?></label>
            <div class="input">
                <?php $action_deposit = $action->fetchDeposit($symmetric_key) ?>
                <input name="deposit" class="span2" type="text" value="<?php if ($action_deposit) echo $action_deposit ?>" />
                <span class="help-inline"><?php echo __('Use a period "." for decimal separator') ?></span>
            </div>
        </div>
        <div class="clearfix">
            <label><?php echo __('Withdrawal') ?></label>
            <div class="input">
                <?php $action_withdrawal = $action->fetchWithdrawal($symmetric_key) ?>
                <input name="withdrawal" class="span2" type="text" value="<?php if ($action_withdrawal) echo $action_withdrawal ?>" />
                <span class="help-inline"><?php echo __('Use a period "." for decimal separator') ?></span>
            </div>
        </div>
        <div class="clearfix">
            <label><?php echo __('Tags') ?></label>
            <div class="input">
                <input name="tags" class="span5" type="text" id="tags" value="<?php echo $tags ?>" />
                <span class="help-inline"><?php echo __('Use the comma as delimeter (e.g. Home, Rent, Athens)') ?></span>
            </div>
        </div>
        <div class="clearfix">
            <input name="submit" class="btn primary" type="submit" value="<?php echo __('Update') ?>" />
        </div>
    </fieldset>
</form>

