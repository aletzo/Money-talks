<div id="flash_wrapper">
    <?php
    if ($sf_user->hasFlash('error')
        || $sf_user->hasFlash('info')
        || $sf_user->hasFlash('success')
        || $sf_user->hasFlash('warning')) :
        ?>
        <?php if ($sf_user->hasFlash('error')) : ?>
            <div id="flash" class="alert alert-error"><?php echo $sf_user->getFlash('error') ?></div>
        <?php elseif ($sf_user->hasFlash('info')) : ?>
            <div id="flash" class="alert alert-info"><?php echo $sf_user->getFlash('info') ?></div>
        <?php elseif ($sf_user->hasFlash('success')) : ?>
            <div id="flash" class="alert alert-success"><?php echo $sf_user->getFlash('success') ?></div>
        <?php endif ?>
    <?php endif ?>
</div>
