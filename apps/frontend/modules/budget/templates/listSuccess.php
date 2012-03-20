<?php use_javascript('budget-delete', 'last') ?>

<?php use_helper('I18N') ?>

<?php if ($budgets) : ?>
    <table class="table table-bordered table-striped table-condensed">
        <thead>
            <tr>
                <th width="150"><?php echo __('Budget') ?></th>
                <th width="60"><?php echo __('Amount') ?></th>
                <th width="60"><?php echo __('Remaining') ?></th>
                <th width="300" colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($budgets as $budget) : ?>
                <tr>
                    <td>
                        <?php foreach ($budget['tags'] as $tag) : ?>
                            <span class="label label-inverse"><?php echo $tag ?></span>
                        <?php endforeach ?>

                        <span class="label pull-right"><?php echo $budget['tags_combined'] ? __('and') : __('or') ?></span>
                    </td>
                    <td><?php echo number_format($budget['amount'], 2) ?></td>
                    <td>
                        <span class="<?php echo $budget['diff'] < 0 ? 'red' : 'green' ?>"><?php echo number_format($budget['diff'], 2) ?></span>
                    </td>
                    <td>
                        <div class="progress progress-striped progress-<?php echo $budget['status'] ?>">
                            <div class="bar" style="width: <?php echo $budget['percentage'] ?>%"> </div>
                            <span<?php if ($budget['percentage'] > 10) echo ' class="white"' ?>><?php echo __('%money%', array('%money%' => number_format($budget['current'], 2))) ?></span>
                        </div>
                    </td>
                    <td width="32">
                        <a class="budget_edit" href="<?php echo url_for('@budget_edit?id=' . $budget['id']) ?>" class="btn"><i class="icon-pencil" title="<?php echo __('Edit') ?>"></i></a>
                        <a class="budget_delete" href="#modal_budget_delete" rel="<?php echo $budget['id'] ?>" data-toggle="modal"><i class="icon-remove" title="<?php echo __('Delete') ?>"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php else : ?>
    <h2><?php echo __('No budgets found.') ?></h2>
<?php endif ?>
<div class="form-stacked">
    <div class="actions">
        <a class="btn btn-primary" href="<?php echo url_for('@budget_new') ?>"><i class="icon-plus icon-white"></i> <?php echo __('Create new budget') ?></a>
        <?php if ($next_month && $next_year) : ?>
            <a class="btn pull-right" href="<?php echo url_for('@budget_list?month=' . $next_month . '&year=' . $next_year) ?>"><i class="icon-arrow-right"></i> <?php echo __('Next month') ?></a>
        <?php endif ?>
        <?php if ($current_month_year) : ?>
            <a class="btn pull-right" href="<?php echo url_for('@budget_list') ?>"><?php echo __('Current month') ?></a>
        <?php endif ?>
        <a class="btn pull-right" href="<?php echo url_for('@budget_list?month=' . $previous_month . '&year=' . $previous_year) ?>"><i class="icon-arrow-left"></i> <?php echo __('Previous month') ?></a>
    </div>
</div>

<div class="modal fade" id="modal_budget_delete">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3><?php echo __('Delete budget') ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo __('This is irreversible. Beware!') ?></p>
    </div>
    <div class="modal-footer">
        <a id="budget_delete" class="btn btn-primary" href="<?php echo url_for('@budget_delete?id=budget_id') ?>"><?php echo __('Delete') ?></a>
    </div>
</div>
