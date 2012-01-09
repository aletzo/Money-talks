<?php

/**
 * account actions.
 *
 * @package    moneytalks 
 * @subpackage account
 * @author     ajo@mydevnull.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accountActions extends sfActions
{
    protected $user_id = null;

    public function preExecute()
    {
        parent::preExecute();

        $this->user_id = $this->getUser()->getGuardUser()->id;
    }


    public function executeList(sfWebRequest $request)
    {
        $this->getUser()->setHeader('My accounts');

        $this->accounts = AccountTable::fetch($this->user_id);

        $this->balance = 0;

        foreach ($this->accounts as $account) {
            $this->balance += $account->fetchBalance();
        }
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Create new account');

        if ($request->isMethod(sfWebRequest::POST)) {
            $name = $request->getParameter('name');

            if ( ! $name) {
                $this->getUser()->setFlash('error', 'Please provide a name for the account.');

                $this->redirect('@account_new');
            } else {
                $account = new Account();
                $account->name = $name;
                $account->user_id = $this->user_id;
                $account->setBalance(0);
                $account->save();

                $this->getUser()->setFlash('success', 'The account "' . $account->name . '" was created successfully!');

                $this->redirect('@account_view?id=' . $account->id);
            }
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Edit account');

        $this->account = AccountTable::fetch($this->user_id, $request->getParameter('id'));

        if ( ! $this->account) {
            $this->getUser()->setFlash('error', 'Account not found.');
            
            $this->redirect('@account_list');
        }

        if ($request->isMethod(sfWebRequest::POST)) {
            $name = $request->getParameter('name');

            if ( ! $name) {
                $this->getUser()->setFlash('error', 'Please provide a name for the account.');

                $this->redirect('@account_edit?id=' . $this->account->id);
            } else {
                $this->account->name = $name;
                $this->account->save();

                $this->getUser()->setFlash('success', 'The account "' . $this->account->name . '" was updated successfully!');

                $this->redirect('@account_view?id=' . $this->account->id);
            }
        }
    }

    public function executeDelete(sfWebRequest $request)
    {
        $account = AccountTable::fetch($this->user_id, $request->getParameter('id'));

        if ( ! $account) {
            $this->getUser()->setFlash('error', 'Account not found.');
        } else {
            if ($account->delete()) {
                $this->getUser()->setFlash('success', 'The account "' . $account->name . '" was deleted successfully.');
            } else {
                $this->getUser()->setFlash('error', 'Failed to delete the account.');
            }
        }
        
        $this->redirect('@account_list');
    }

    public function executeView(sfWebRequest $request)
    {
        $this->account = AccountTable::fetch($this->user_id, $request->getParameter('id'), true, true);

        if ($this->account) {
            $this->getUser()->setHeader($this->account['name'] . ' <small>details</small>');

            $this->getUser()->setAttribute('account_id', $this->account['id']); //used to associate the actions CRUD with an account
        } else {
            $this->getUser()->setFlash('error', 'Account not found.');

            $this->redirect('@account_list');
        }
    }

}

