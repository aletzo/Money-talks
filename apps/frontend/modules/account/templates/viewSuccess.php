<?php use_javascript('bootstrap-modal', 'last') ?>
<?php use_javascript('account-delete', 'last') ?>
<?php use_javascript('jquery.tablesorter.min.js', 'last') ?>
<?php use_javascript('account-table-sort', 'last') ?>
<?php use_helper('I18N', 'String') ?>
<table class="bordered-table condensed-table zebra-striped">
    <thead>
        <tr>
            <th><?php echo __('Date') ?></th>
            <th><?php echo __('Name') ?></th>
            <th><?php echo __('Deposit') ?></th>
            <th><?php echo __('Withdrawal') ?></th>
            <th><?php echo __('Balance') ?></th>
            <th><?php echo __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($account['Actions'] as $action) : ?>
            <tr>
                <td><?php echo $action['date'] ?></td>
                <td>
                    <?php echo $action['name'] ?>
                    <?php if ($action['Tags']) : ?>
                        <span class="pull-right">
                            <?php foreach ($action['Tags'] as $tag) : ?>
                                <span class="label notice"><?php echo mb_convert_case($tag['name'], MB_CASE_TITLE, 'UTF-8'); ?></span>
                            <?php endforeach ?>
                        </span>
                    <?php endif ?>
                </td>
                <td><span class="green"><?php if ($action['deposit']) echo number_format($action['deposit'], 2, '.', '') ?></span></td>
                <td><span class="red"><?php if ($action['withdrawal']) echo number_format($action['withdrawal'], 2, '.', '') ?></span></td>
                <td><span class="<?php echo $action['balance'] < 0 ? 'red' : 'green' ?>"><?php echo number_format($action['balance'], 2, '.', '') ?></span></td>
                <td>
                    <a href="#"><?php echo __('Delete') ?></a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4"><?php echo __('Total') ?></td>
            <td colspan="2"><span class="<?php echo $account['balance'] < 0 ? 'red' : 'green' ?>"><?php echo number_format($account['balance'], 2) ?></span></td>
        </tr>
    </tfoot>
</table>
<div class="form-stacked">
    <div class="actions">
        <a class="btn primary" href="<?php echo url_for('@action_new') ?>"><?php echo __('Add action') ?></a>
        <button id="account_delete" class="btn danger pull-right" data-keyboard="true" data-backdrop="true" data-controls-modal="modal_account_delete"><?php echo __('Delete the account') ?></button>
        <a class="btn pull-right" href="<?php echo url_for('@account_edit?id=' . $account['id']) ?>"><?php echo __('Edit the account') ?></a>
    </div>
</div>

<div class="modal hide fade" id="modal_account_delete">
    <div class="modal-header">
        <a class="close" href="#">×</a>
        <h3>Delete the account "<?php echo $account['name'] ?>"</h3>
    </div>
    <div class="modal-body">
        <p>This action is irreversible. Beware!</p>
    </div>
    <div class="modal-footer">
        <a class="btn primary" href="<?php echo url_for('@account_delete?id=' . $account['id']) ?>"><?php echo __('Delete') ?></a>
    </div>
</div>

