<?php use_helper('I18N') ?>

<?php if ($budgets) : ?>
    <table>
        <thead>
            <tr>
                <th><?php echo __('Budget') ?></th>
                <th><?php echo __('Limit') ?></th>
                <th><?php echo __('Status') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($budgets as $budget) : ?>
                <tr>
                    <td>
                        <?php foreach ($budget['tags'] as $tag) : ?>
                            <span class="label notice"><?php echo $tag ?></span>
                        <?php endforeach ?>
                    </td>
                    <td><?php echo $budget['amount'] ?><span class="<?php echo $budget['amount'] < $budget['current'] ? 'red' : 'green' ?>"><?php echo number_format($budget['amount'] - $budget['current'], 2) ?></span></td>
                    <td>
                        <div class="progress">
                            <div class="bar" style="width: <?php echo $budget['current'] / $budget['amount'] ?>%"> </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php else : ?>
    <h2><?php echo __('You have not set any budgets yet.') ?></h2>
<?php endif ?>
<div class="form-stacked">
    <div class="actions">
        <a class="btn primary" href="<?php echo url_for('@budget_new') ?>"><?php echo __('Create new budget') ?></a>
    </div>
</div>
