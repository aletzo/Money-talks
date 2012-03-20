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
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="<?php echo url_for('@homepage') ?>"><?php echo sfConfig::get('project_name') ?></a>

                    <ul class="nav">
                        <li rel="home"><a href="<?php echo url_for('@homepage') ?>"><?php echo __('Home') ?></a></li>
                        <?php if ($sf_user->isAuthenticated()) : ?>
                            <li rel="account" class="dropdown">
                                <a href="#" data-toggle="dropdown"><?php echo __('Accounts') ?> <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo url_for('@account_list') ?>"><?php echo __('all') ?></a></li>
                                    <li class="divider"></li>
                                    <?php foreach ($sf_user->getGuardUser()->Accounts as $account) : ?>
                                        <li><a href="<?php echo url_for('@account_view?id=' . $account->id)?>"><?php echo $account->name ?></a></li>
                                    <?php endforeach ?>
                                </ul>
                            </li>
                            <li rel="budget"><a href="<?php echo url_for('@budget_list') ?>"><?php echo __('Budgets') ?></a></li>
                            <li rel="report"><a href="<?php echo url_for('@report_list') ?>"><?php echo __('Reports') ?></a></li>
                        <?php endif ?>
                        <li rel="about"><a href="<?php echo url_for('@about') ?>"><?php echo __('About') ?></a></li>
                        <li rel="contact"><a href="<?php echo url_for('@contact') ?>"><?php echo __('Contact') ?></a></li>
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
                    <div class="span12">
                        <?php include_partial('global/flash') ?>
                        <?php echo $sf_content ?>
                    </div>
                </div>
            </div>

            <footer style="height:60px; margin: 20px 0 0">
                <p><a id="vanity_card" href="http://mydevnull.net" target="_blank">~/dev/null</a></p>
                <p><img id="konami_img" style="display:none;height:10px" src="/images/konami_code.png" /></p>
            </footer>
        </div> <!-- /container -->
        <?php include_javascripts() ?>
    </body>
</html>
