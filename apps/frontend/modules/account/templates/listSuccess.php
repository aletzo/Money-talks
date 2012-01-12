<?php use_helper('I18N') ?>

<?php if ($accounts) : ?>
    <table>
        <thead>
            <tr>
                <th><?php echo __('Name') ?></th>
                <th><?php echo __('Balance') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accounts as $account) : ?>
                <tr>
                    <td><a href="<?php echo url_for('@account_view?id=' . $account->id) ?>"><?php echo $account->name ?></a></td>

                    <?php $account_balance = $account->fetchBalance($symmetric_key) ?>
                    <td><span class="<?php echo $account_balance < 0 ? 'red' : 'green' ?>"><?php echo number_format($account_balance, 2) ?></span></td>
                </tr>
            <?php endforeach ?>
                <tr>
                    <td><?php echo __('Total') ?></td>
                    <td><span class="<?php echo $balance < 0 ? 'red' : 'green' ?>"><?php echo number_format($balance, 2) ?></span></td>
                </tr>
        </tbody>
    </table>
<?php else : ?>
    <h2><?php echo __('You don\'t have any accounts yet.') ?></h2>
<?php endif ?>
<div class="form-stacked">
    <div class="actions">
        <a class="btn primary" href="<?php echo url_for('@account_new') ?>"><?php echo __('Create new account') ?></a>
    </div>
</div>
