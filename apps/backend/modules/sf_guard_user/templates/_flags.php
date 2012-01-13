<?php if ($sf_guard_user->is_active) : ?>
<img src="/sfDoctrinePlugin/images/tick.png" title="<?php echo __('active') ?>" />
<?php else : ?>
<img src="images/delete.png" title="<?php echo __('inactive') ?>" />
<?php endif ?>
<?php if ($sf_guard_user->is_super_admin) : ?>
<img src="/sfDoctrinePlugin/images/tick.png" title="super admin" />
<?php endif ?>
