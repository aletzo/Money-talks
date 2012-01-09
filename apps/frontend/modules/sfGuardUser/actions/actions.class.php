<?php

//require_once sfConfig::get('sf_plugins_dir') . '/sfDoctrineGuardPlugin/modules/sfGuardUser/lib/sfGuardUserGeneratorConfiguration.class.php';
//require_once sfConfig::get('sf_plugins_dir') . '/sfDoctrineGuardPlugin/modules/sfGuardUser/lib/sfGuardUserGeneratorHelper.class.php';

require_once sfConfig::get('sf_plugins_dir') . '/sfDoctrineGuardPlugin/modules/sfGuardUser/lib/BasesfGuardUserActions.class.php';

/**
 * sfGuardUser actions.
 *
 * @package    moneytalks
 * @subpackage sfGuardUser
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
class sfGuardUserActions extends BasesfGuardUserActions
{
    public function preExecute()
    {
        $this->redirect('@homepage'); //TODO: check for correct credentials

        if ( ! $this->getUser()->isAuthenticated()) {
            $this->redirect('@homepage');
        }

        parent::preExecute();
    }
}
