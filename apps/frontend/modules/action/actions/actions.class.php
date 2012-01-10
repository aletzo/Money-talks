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

        $this->available_tags = TagTable::fetchUserTags($this->user_id);

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

            $tags = $request->getParameter('tags');

            $tags = rtrim($tags, ', ');

            if ( ! empty($tags)) {
                $tags = explode(',', $tags);

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
            }

            $this->getUser()->setFlash('success', 'New action added successfully!');

            $this->redirect('@account_view?id=' . $this->account->id);
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Edit action');

        $this->action = ActionTable::getInstance()->findOneByIdAndUser_id($request->getParameter('id'), $this->user_id);

        if ( ! $this->action) {
            $this->getUser()->setFlash('error', 'Action not found.');
        }

        $this->available_tags = TagTable::fetchUserTags($this->user_id);

        $tags = array();

        foreach ($this->action->Tags as $tag) {
            $tags[] = $tag->name;
        }

        $this->tags = implode(', ', $tags);

        include_once(sfConfig::get('sf_root_dir') . '/lib/helper/StringHelper.php');

        $this->tags = mb_ucase_words($this->tags);

        if ($request->isMethod(sfWebRequest::POST)) {
            $name = $request->getParameter('name');

            if ( ! $name) {
                $this->getUser()->setFlash('error', 'Please provide a name for the action.');

                $this->redirect('@action_edit?id=' . $this->action->id);
            }

            $this->action->name = $name;

            $date = $request->getParameter('date');
            $this->action->date = $date ? $date : date('Y-m-d');
            
            $deposit = $request->getParameter('deposit');
            $withdrawal = $request->getParameter('withdrawal');

            $balance = $this->action->Account->fetchBalance();

            $oldDeposit = $this->action->fetchDeposit();

            if ($deposit && $deposit != $oldDeposit) {
                $balance -= $oldDeposit;

                $this->action->setDeposit($deposit);

                $balance += $deposit;
            }

            $oldWithdrawal = $this->action->fetchWithdrawal();

            if ($withdrawal && $withdrawal != $oldWithdrawal) {
                $balance += $oldWithdrawal;

                $this->action->setWithdrawal($withdrawal);

                $balance -= $withdrawal;
            }

            $this->action->storeBalance($balance); //$this->action->save() is also called
            
            $newTags = $request->getParameter('tags');

            $newTags = rtrim($newTags, ', ');

            if (empty($newTags)) {
                $q = Doctrine_Query::create()
                    ->delete('ActionTag at')
                    ->where('at.action_id = ?', $this->action->id);

                $q->execute(); //delete the tags that are no longer used
            } else {
                $newTags = mb_strtolower($newTags, 'UTF-8');
                $newTags = explode(',', $newTags);
                $newTags = array_map('trim', $newTags);

                $q = Doctrine_Query::create()
                    ->from('ActionTag at')
                    ->leftJoin('at.Tag t')
                    ->whereNotIn('t.name', $newTags)
                    ->andWhere('at.action_id = ?', $this->action->id);

                $oldTags = $q->execute(); //find the tags that are no longer used

                foreach ($oldTags as $oldTag) {
                    $oldTag->delete(); //and delete them (NOT softdelete)
                }

                foreach ($newTags as $tagName) {
                    $tagName = mb_strtolower(trim($tagName), 'UTF-8'); //strtolower to avoid duplicates

                    $tag = TagTable::getInstance()->findOneByNameAndUser_id($tagName, $this->user_id);

                    if ( ! $tag) {
                        $tag = new Tag();
                        $tag->user_id = $this->user_id;
                        $tag->name = $tagName;
                        $tag->save();
                    }

                    $actionTag = ActionTagTable::getInstance()->findOneByAction_idAndTag_id($this->action->id, $tag->id);

                    if ( ! $actionTag) { // if the tag is new, add it now
                        $actionTag = new ActionTag();
                        $actionTag->action_id = $this->action->id;
                        $actionTag->tag_id = $tag->id;
                        $actionTag->save();
                    }
                }
            }

            $this->getUser()->setFlash('success', 'The action "' . $this->action->name . '" was updated successfully!');

            $this->redirect('@account_view?id=' . $this->action->account_id);
        }
    }

    public function executeDelete(sfWebRequest $request)
    {
        $action = ActionTable::getInstance()->findOneByIdAndUser_id($request->getParameter('id'), $this->user_id);

        if ( ! $action) {
            $this->getUser()->setFlash('error', 'Action not found.');
    
            $this->redirect('@account_list');

        } else {
            $accountId = $action->account_id;

            if ($action->delete()) {
                $this->getUser()->setFlash('success', 'The action "' . $action->name . '" was deleted successfully.');
            } else {
                $this->getUser()->setFlash('error', 'Failed to delete the action.');
            }

            $this->redirect('@account_view?id=' . $accountId);
        }
    }

}

