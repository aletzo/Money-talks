<?php use_javascript('bootstrap-modal', 'last') ?>
<?php use_javascript('account-delete', 'last') ?>
<?php use_javascript('action-delete', 'last') ?>
<?php use_javascript('jquery.tablesorter.min.js', 'last') ?>
<?php use_javascript('account-table-sort', 'last') ?>
<?php use_javascript('actions-filters', 'last') ?>

<?php use_helper('I18N', 'String') ?>

<div id="filters">
    <form id="filters_form" action="<?php echo url_for('@account_view?id=' . $account->id) ?>" method="POST">
        <label><input type="radio" name="history" value="12" <?php if ($history == 12) echo  ' checked' ?> /> <?php echo __('1 year') ?></label>
        <label><input type="radio" name="history" value="3" <?php if ($history == 3) echo ' checked' ?>/> <?php echo __('3 months') ?></label>
        <label><input type="radio" name="history" value="1" <?php if ($history == 1 ) echo ' checked' ?> /> <?php echo __('1 month') ?></label>
        <div class="spacer">&nbsp;</div>
        <label><input type="checkbox" name="deposit" <?php if ($deposit) echo ' checked' ?> /> <?php echo __('Deposits') ?></label>
        <label><input type="checkbox" name="withdrawal" <?php if ($withdrawal) echo ' checked' ?> /> <?php echo __('Withdrawals') ?></label>
    </form>
</div>

<table class="bordered-table condensed-table zebra-striped">
    <thead>
        <tr>
            <th class="tooltip" title="<?php echo __('sort by %column%', array('%column%' => __('Date')))?>" width="70"><?php echo __('Date') ?></th>
            <th class="tooltip" title="<?php echo __('sort by %column%', array('%column%' => __('Name')))?>" ><?php echo __('Name') ?></th>
            <th class="tooltip" title="<?php echo __('sort by %column%', array('%column%' => __('Deposit')))?>" width="80"><?php echo __('Deposit') ?></th>
            <th class="tooltip" title="<?php echo __('sort by %column%', array('%column%' => __('Withdrawal')))?>" width="80"><?php echo __('Withdrawal') ?></th>
            <th class="tooltip" title="<?php echo __('sort by %column%', array('%column%' => __('Balance')))?>" width="80"><?php echo __('Balance') ?></th>
            <th width="10"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($actions as $action) : ?>
            <tr>
                <td><?php echo $action->date ?></td>
                <td>
                    <a href="<?php echo url_for('@action_edit?id=' . $action->id) ?>"><?php echo $action->name ?></a>
                    <?php if ($action->Tags) : ?>
                        <span class="pull-right">
                            <?php foreach ($action->Tags as $tag) : ?>
                                <span class="label notice"><?php echo mb_convert_case($tag->name, MB_CASE_TITLE, 'UTF-8'); ?></span>
                            <?php endforeach ?>
                        </span>
                    <?php endif ?>
                </td>
                <?php $action_deposit = $action->fetchDeposit($symmetric_key) ?>
                <td><span class="green pull-right"><?php if ($action_deposit) echo number_format($action_deposit, 2, '.', '') ?></span></td>
                <?php $action_withdrawal = $action->fetchWithdrawal($symmetric_key) ?>
                <td><span class="red pull-right"><?php if ($action_withdrawal) echo number_format($action_withdrawal, 2, '.', '') ?></span></td>
                <?php $action_balance = $action->fetchBalance($symmetric_key) ?>
                <td><span class="<?php echo $action_balance < 0 ? 'red' : 'green' ?> pull-right tooltip" title="<?php echo __('as calculated when the action was last updated') ?>"><?php echo number_format($action_balance, 2, '.', '') ?></span></td>
                <td>
                    <a class="action_delete pull-right" href="#" rel="<?php echo $action->id ?>" class="btn" data-keyboard="true" data-backdrop="true" data-controls-modal="modal_action_delete">
                        <img class="tooltip" title="<?php echo __('Delete') ?>" src="/images/delete.png" />
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <?php $account_balance = $account->fetchBalance($symmetric_key) ?>
            <td colspan="5"><span class="<?php echo $account_balance < 0 ? 'red' : 'green' ?> pull-right"><?php echo __('Current balance:') . ' ' . number_format($account_balance, 2) ?></span></td>
            <td></td>
        </tr>
    </tfoot>
</table>
<div class="form-stacked">
    <div class="actions">
        <a class="btn primary" href="<?php echo url_for('@action_new') ?>"><?php echo __('Add action') ?></a>
        <button id="account_delete" class="btn danger pull-right" data-keyboard="true" data-backdrop="true" data-controls-modal="modal_account_delete"><?php echo __('Delete the account') ?></button>
        <a class="btn pull-right" href="<?php echo url_for('@account_edit?id=' . $account->id) ?>"><?php echo __('Edit the account') ?></a>
    </div>
</div>

<div class="modal hide fade" id="modal_account_delete">
    <div class="modal-header">
        <a class="close" href="#">×</a>
        <h3><?php echo __('Delete the account "%name%"', array('%name%' => $account->name)) ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo __('This is irreversible. Beware!') ?></p>
    </div>
    <div class="modal-footer">
        <a class="btn primary" href="<?php echo url_for('@account_delete?id=' . $account->id) ?>"><?php echo __('Delete') ?></a>
    </div>
</div>

<div class="modal hide fade" id="modal_action_delete">
    <div class="modal-header">
        <a class="close" href="#">×</a>
        <h3><?php echo __('Delete action') ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo __('This is irreversible. Beware!') ?></p>
    </div>
    <div class="modal-footer">
        <a id="action_delete" class="btn primary" href="<?php echo url_for('@action_delete?id=action_id') ?>"><?php echo __('Delete') ?></a>
    </div>
</div>
