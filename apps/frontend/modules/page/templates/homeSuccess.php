<?php use_helper('I18N') ?>

<div class="row">    
    <div class="span4">&nbsp;</div>
    <div class="span8">

        <h3><?php echo __('What is this?') ?></h3>
        <p><?php echo __('This is a simple web app to log your expences and your income, so that you can keep track of what\'s happening.') ?></p>

        <h3><?php echo __('How do I join?') ?></h3>
        <p><?php echo __('You may either %register% or %login% with your google or yahoo account', array(
            '%register%' => '<a href="' . url_for('@sf_guard_register') . '">' . __('register') . '</a>',
            '%login%' => '<a href="' . url_for('@sf_guard_signin') . '">' . __('log in') . '</a>'
        )) ?></p>

        <h3><?php echo __('So, when I join, am I giving you access to all my personal finance data?') ?></h3>
        <p><?php echo __('Every single money number is stored encrypted. No-one can know your actual finance status, but you!') ?></p>

        <h3><?php echo __('Is it free?') ?></h3>
        <p><?php echo __('The application will remain free, while it is under development / beta mode. There will be a small annual fee once it\'s ready, to cover the hosting and maintenance costs.') ?></p>
    </div>
</div>
