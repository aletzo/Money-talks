<?php

/**
 * page actions.
 *
 * @package    cinemalovr
 * @subpackage page
 * @author     ajo@mydevnull.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pageActions extends sfActions
{

    public function executeHome(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Welcome');
    }

    public function executeAbout(sfWebRequest $request)
    {
        $this->getUser()->setHeader('About');
    }

    public function executeContact(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Contact');
    }

}
