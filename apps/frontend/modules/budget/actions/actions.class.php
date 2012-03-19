<?php

/**
 * budget actions.
 *
 * @package    moneytalks 
 * @subpackage budget
 * @author     ajo@mydevnull.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class budgetActions extends sfActions
{

    public function executeList(sfWebRequest $request)
    {
        $this->user_id = $this->getUser()->getGuardUser()->id;
        $this->symmetric_key = $this->getUser()->getSymmetricKey();

        BudgetTable::calculateUserBudgets($this->user_id, $this->symmetric_key);

        $this->getUser()->setHeader('My budgets');

        $this->budgets = BudgetTable::fetchThisMonth($this->user_id, $this->symmetric_key, date('m'), date('Y'));

    }

    public function executeNew(sfWebRequest $request)
    {
        $this->user_id = $this->getUser()->getGuardUser()->id;
        $this->symmetric_key = $this->getUser()->getSymmetricKey();

        $this->getUser()->setHeader('Create new budget');

        $this->available_tags = TagTable::fetchUserTags($this->user_id);

        if ($request->isMethod(sfWebRequest::POST)) {
            $amount = $request->getParameter('amount');

            if ( ! $amount) {
                $this->getUser()->setFlash('error', 'Please provide an amount for the budget.');

                $this->redirect('@budget_new');
            }

            $budget = new Budget();
            $budget->user_id = $this->user_id;
            $budget->month = date('m');
            $budget->year = date('Y');

            $budget->storeAmount($amount, $this->symmetric_key);

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

                    $budgetTag = new BudgetTag();
                    $budgetTag->budget_id = $budget->id;
                    $budgetTag->tag_id = $tag->id;
                    $budgetTag->save();
                }
            }

            $budget->calculateCurrent($this->symmetric_key);

            $this->getUser()->setFlash('success', 'New budget added successfully!');

            $this->redirect('@budget_list');
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Edit budget');

    }

    public function executeDelete(sfWebRequest $request)
    {
        $budget = BudgetTable::fetch($this->user_id, $request->getParameter('id'));

        if ( ! $budget) {
            $this->getUser()->setFlash('error', 'Budget not found.');
        } else {
            if ($budget->delete()) {
                $this->getUser()->setFlash('success', 'The budget was deleted successfully.');
            } else {
                $this->getUser()->setFlash('error', 'Failed to delete the budget.');
            }
        }
        
        $this->redirect('@budget_list');
    }

}

