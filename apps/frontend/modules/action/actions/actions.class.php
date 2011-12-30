<?php

/**
 * action actions.
 *
 * @package    moneytalks 
 * @subpackage action
 * @author     ajo@mydevnull.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class actionActions extends sfActions
{
    protected $user_id = null;

    public function preExecute()
    {
        parent::preExecute();

        $this->user_id = $this->getUser()->getGuardUser()->id;
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->account = AccountTable::fetch($this->getUser()->getGuardUser()->id, $this->getUser()->getAttribute('account_id'));

        if ( ! $this->account) {
            $this->getUser()->setFlash('error', 'Invalid account provided.');

            $this->redirect('@account_list');
        }

        $this->getUser()->setHeader('Add action <small>to ' . $this->account->name . '</small>');

        if ($request->isMethod(sfWebRequest::POST)) {
            $name = $request->getParameter('name');
            $deposit = $request->getParameter('deposit');
            $withdrawal = $request->getParameter('withdrawal');

            if ( ! $name) {
                $this->getUser()->setFlash('error', 'Please provide a name for the account.');

                $this->redirect('@action_new');
            }

            if ( ! $deposit && ! $withdrawal) {
                $this->getUser()->setFlash('error', 'Please enter a value for the deposit or the withdrawal.');

                $this->redirect('@action_new');
            }

            $action = new Action();
            $action->account_id = $this->account->id;
            $action->user_id = $this->user_id;
            $date = $request->getParameter('date');
            $action->date = $date ? $date : date('Y-m-d');
            $action->name = $name;
            
            $balance = $this->account->fetchBalance();

            if ($deposit) {
                $action->setDeposit($deposit);

                $balance += $deposit;
            }

            if ($withdrawal) {
                $action->setWithdrawal($withdrawal);

                $balance -= $withdrawal;
            }

            $action->storeBalance($balance); //$action->save() is also called

            $tags = explode(',', $request->getParameter('tags'));

            foreach ($tags as $tagName) {
                $tagName = mb_strtolower(trim($tagName), 'UTF-8'); //strtolower to avoid duplicates

                $tag = TagTable::getInstance()->findOneByNameAndUser_id($tagName, $this->user_id);

                if ( ! $tag) {
                    $tag = new Tag();
                    $tag->user_id = $this->user_id;
                    $tag->name = $tagName;
                    $tag->save();
                }

                $actionTag = new ActionTag();
                $actionTag->action_id = $action->id;
                $actionTag->tag_id = $tag->id;
                $actionTag->save();
            }

            $this->getUser()->setFlash('success', 'New action added successfully!');

            $this->redirect('@account_view?id=' . $this->account->id);
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Edit account');

        $this->account = AccountTable::getInstance()->find($request->getParameter('id'));

        if ( ! $this->account) {
            $this->getUser()->setFlash('error', 'Account not found.');
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
    }

}

