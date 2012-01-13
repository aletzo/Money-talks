<?php

/**
 * page actions.
 *
 * @package    moneytalks
 * @subpackage page
 * @author     ajo@mydevnull.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pageActions extends sfActions
{

    public function executeHome(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Hi!');

        if ($this->getUser()->isAuthenticated() && $this->getUser()->getGuardUser()->is_super_admin === false) {
            $this->getUser()->setFlash('error', 'you are not allowed here :(');
            $this->redirect('@sf_guard_signout');
        }
    }

}
