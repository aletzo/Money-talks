<?php use_helper('I18N') ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
    </head>
    <body>

        <div class="topbar">
            <div class="fill">
                <div class="container">
                    <a class="brand" href="<?php echo url_for('@homepage') ?>"><?php echo sfConfig::get('project_name') ?></a>

                    <ul class="nav">
                        <li><a href="<?php echo url_for('@homepage') ?>"><?php echo __('Home') ?></a></li>
                        <?php if ($sf_user->isAuthenticated()) : ?>
                            <li><a href="<?php echo url_for('@account_list') ?>"><?php echo __('Accounts') ?></a></li>
                            <li><a href="<?php echo url_for('@report_list') ?>"><?php echo __('Reports') ?></a></li>
                        <?php endif ?>
                        <li><a href="<?php echo url_for('@about') ?>"><?php echo __('About') ?></a></li>
                        <li><a href="<?php echo url_for('@contact') ?>"><?php echo __('Contact') ?></a></li>
                    </ul>
                    
                    <?php include_partial('global/usermenu') ?>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="content">
                <div class="page-header">
                    <h1><?php echo html_entity_decode($sf_user->getHeader()) ?></h1>
                </div>
                <div class="row">
                    <div class="span16">
                        <?php include_partial('global/flash') ?>
                        <?php echo $sf_content ?>
                    </div>
                </div>
            </div>

            <footer style="height:60px">
                <p><a id="vanity_card" href="http://mydevnull.net" target="_blank">~/dev/null</a></p>
                <p><img id="konami_img" style="display:none;height:10px" src="/images/konami_code.png" /></p>
            </footer>
        </div> <!-- /container -->
        <?php include_javascripts() ?>
    </body>
</html>
