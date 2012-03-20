<?php use_javascript('action-delete', 'last') ?>
<?php use_javascript('jquery.tablesorter.min.js', 'last') ?>
<?php use_javascript('account-table-sort', 'last') ?>

<?php use_javascript('actions-filters', 'last') ?>

<?php use_helper('I18N', 'String') ?>

<div id="filters">
    <form id="filters_form" action="<?php echo url_for('@account_view?id=' . $account->id) ?>" method="POST">
        <input type="hidden" id="deposit_value" name="deposit" value="<?php echo $deposit ? 'true' : 'false' ?>" />
        <input type="hidden" id="withdrawal_value" name="withdrawal" value="<?php echo $withdrawal ? 'true' : 'false' ?>" />
        <input type="hidden" id="history_value" name="history" value="<?php echo $history ?>" />

        <div class="filters-group">
            <div class="btn-group" data-toggle="buttons-checkbox">
                <button id="deposit" class="btn<?php if ($deposit) echo ' active' ?>"><?php echo __('Deposits') ?></button>
                <button id="withdrawal" class="btn<?php if ($withdrawal) echo ' active' ?>"><?php echo __('Withdrawals') ?></button>
            </div>
        </div>
        <div class="filters-group last">
            <div class="btn-group" data-toggle="buttons-radio">
                <button id="history_1" class="btn<?php if ($history == 1) echo ' active' ?>"><?php echo __('1 month') ?></button>
                <button id="history_3" class="btn<?php if ($history == 3) echo ' active' ?>"><?php echo __('3 months') ?></button>
                <button id="history_12" class="btn<?php if ($history == 12) echo ' active' ?>"><?php echo __('1 year') ?></button>
            </div>
        </div>
    </form>
</div>

<table class="table table-bordered table-condensed table-striped">
    <thead>
        <tr>
            <th title="<?php echo __('sort by %column%', array('%column%' => __('Date')))?>" width="70"><?php echo __('Date') ?></th>
            <th title="<?php echo __('sort by %column%', array('%column%' => __('Name')))?>" width="550"><?php echo __('Name') ?></th>
            <th title="<?php echo __('sort by %column%', array('%column%' => __('Deposit')))?>" width="80"><?php echo __('Deposit') ?></th>
            <th title="<?php echo __('sort by %column%', array('%column%' => __('Withdrawal')))?>" width="80"><?php echo __('Withdrawal') ?></th>
            <th title="<?php echo __('sort by %column%', array('%column%' => __('Balance')))?>" width="80"><?php echo __('Balance') ?></th>
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
                                <?php if ($tag->deleted_at !== null) continue ?>
                                <span class="label label-inverse"><?php echo mb_convert_case($tag->name, MB_CASE_TITLE, 'UTF-8'); ?></span>
                            <?php endforeach ?>
                        </span>
                    <?php endif ?>
                </td>
                <?php $action_deposit = $action->fetchDeposit($symmetric_key) ?>
                <td><span class="green pull-right"><?php if ($action_deposit) echo number_format($action_deposit, 2, '.', '') ?></span></td>
                <?php $action_withdrawal = $action->fetchWithdrawal($symmetric_key) ?>
                <td><span class="red pull-right"><?php if ($action_withdrawal) echo number_format($action_withdrawal, 2, '.', '') ?></span></td>
                <?php $action_balance = $action->fetchBalance($symmetric_key) ?>
                <td><span class="<?php echo $action_balance < 0 ? 'red' : 'green' ?> pull-right" title="<?php echo __('as calculated when the action was last updated') ?>"><?php echo number_format($action_balance, 2, '.', '') ?></span></td>
                <td>
                    <a class="action_delete pull-right" href="#modal_action_delete" rel="<?php echo $action->id ?>" data-toggle="modal">
                        <i class="icon-remove" title="<?php echo __('Delete') ?>"></i>
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
        <a class="btn btn-primary" href="<?php echo url_for('@action_new') ?>"><i class="icon-plus icon-white"></i> <?php echo __('Add action') ?></a>
        <a id="account_delete" class="btn btn-danger pull-right" href="#modal_account_delete" data-toggle="modal"><i class="icon-remove icon-white"></i> <?php echo __('Delete the account') ?></a>
        <a class="btn pull-right" href="<?php echo url_for('@account_edit?id=' . $account->id) ?>"><i class="icon-pencil"></i> <?php echo __('Edit the account') ?></a>
    </div>
</div>

<div class="modal fade" id="modal_account_delete">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('Delete the account "%name%"', array('%name%' => $account->name)) ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo __('This is irreversible. Beware!') ?></p>
    </div>
    <div class="modal-footer">
        <a class="btn btn-primary" href="<?php echo url_for('@account_delete?id=' . $account->id) ?>"><?php echo __('Delete') ?></a>
    </div>
</div>

<div class="modal fade" id="modal_action_delete">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('Delete action') ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo __('This is irreversible. Beware!') ?></p>
    </div>
    <div class="modal-footer">
        <a id="action_delete" class="btn btn-primary" href="<?php echo url_for('@action_delete?id=action_id') ?>"><?php echo __('Delete') ?></a>
    </div>
</div>
