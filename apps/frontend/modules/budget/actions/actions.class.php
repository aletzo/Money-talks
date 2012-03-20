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

    public function preExecute()
    {
        parent::preExecute();

        sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
    }

    public function executeList(sfWebRequest $request)
    {
        $this->user_id = $this->getUser()->getGuardUser()->id;
        $this->symmetric_key = $this->getUser()->getSymmetricKey();

        $currentMonth = date('m');
        $currentYear  = date('Y');

        $month = $request->getParameter('month', $currentMonth);
        $year = $request->getParameter('year', $currentYear);

        $this->previous_month = $month == 1 ? 12 : $month - 1;
        $this->previous_year = $this->previous_month == 12 ? $year - 1 : $year;

        $timestamp = mktime(0, 0, 0, $month, 1, $year);
        $currentTimestamp = mktime(0, 0, 0, $currentMonth, 1, $currentYear);

        if ($timestamp < $currentTimestamp) {
            $this->next_month = $month == 12 ? 1 : $month + 1;
            $this->next_year  = $this->next_month == 1 ? $year + 1 : $year;

            $this->current_month_year = true;
        } else {
            $this->next_month = false;
            $this->next_year  = false;

            $this->current_month_year = false;
        }

        BudgetTable::checkMonths($this->user_id, $this->symmetric_key, $month, $year);

        BudgetTable::calculateUserBudgets($this->user_id, $this->symmetric_key);

        $this->getUser()->setHeader(__('My budgets'));

        $this->budgets = BudgetTable::fetchThisMonth($this->user_id, $this->symmetric_key, $month, $year);
    }

    public function executeNew(sfWebRequest $request)
    {
        $this->user_id = $this->getUser()->getGuardUser()->id;
        $this->symmetric_key = $this->getUser()->getSymmetricKey();

        $this->getUser()->setHeader(__('Create new budget'));

        $this->available_tags = TagTable::fetchUserTags($this->user_id);

        if ($request->isMethod(sfWebRequest::POST)) {
            $amount = $request->getParameter('amount');

            if ( ! $amount) {
                $this->getUser()->setFlash('error', __('Please provide an amount for the budget.'));

                $this->redirect('@budget_new');
            }

            $budget = new Budget();
            $budget->user_id = $this->user_id;
            $budget->tags_combined = $request->getParameter('tags_combined', 'or') == 'and';
            $budget->storeAmount($amount, $this->symmetric_key);

            $budgetMonth = new BudgetMonth();
            $budgetMonth->budget_id = $budget->id;
            $budgetMonth->month = date('m');
            $budgetMonth->year = date('Y');

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

            $budgetMonth->calculateCurrent($this->symmetric_key);

            $this->getUser()->setFlash('success', __('New budget added successfully!'));

            $this->redirect('@budget_list');
        }
    }

    public function executeEdit(sfWebRequest $request)
    {
        $this->user_id = $this->getUser()->getGuardUser()->id;
        $this->symmetric_key = $this->getUser()->getSymmetricKey();
        
        $this->getUser()->setHeader(__('Edit budget'));

        $this->budget = BudgetTable::getInstance()->findOneByIdAndUser_id($request->getParameter('id'), $this->user_id);

        if ( ! $this->budget) {
            $this->getUser()->setFlash('error', __('Budget not found.'));

            $this->redirect('@budget_list');
        }

        $this->available_tags = TagTable::fetchUserTags($this->user_id);

        $tags = array();

        foreach ($this->budget->Tags as $tag) {
            $tags[] = $tag->name;
        }

        $this->tags = implode(', ', $tags);

        include_once(sfConfig::get('sf_root_dir') . '/lib/helper/StringHelper.php');

        $this->tags = mb_ucase_words($this->tags);

        if ($request->isMethod(sfWebRequest::POST)) {
            $amount = $request->getParameter('amount');

            if ( ! $amount) {
                $this->getUser()->setFlash('error', __('Please provide an amount for the budget.'));

                $this->redirect('@budget_edit?id=' . $this->budget->id);
            }

            $this->budget->storeAmount($amount, $this->symmetric_key);

            $newTags = $request->getParameter('tags');

            $newTags = rtrim($newTags, ', ');

            if (empty($newTags)) {
                $q = Doctrine_Query::create()
                    ->delete('BudgetTag bt')
                    ->where('bt.budget_id = ?', $this->budget->id);

                $q->execute(); //delete the tags that are no longer used
            } else {
                $newTags = mb_strtolower($newTags, 'UTF-8');
                $newTags = explode(',', $newTags);
                $newTags = array_map('trim', $newTags);

                $q = Doctrine_Query::create()
                    ->from('BudgetTag bt')
                    ->leftJoin('bt.Tag t')
                    ->whereNotIn('t.name', $newTags)
                    ->andWhere('bt.budget_id = ?', $this->budget->id);

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

                    $budgetTag = BudgetTagTable::getInstance()->findOneByBudget_idAndTag_id($this->budget->id, $tag->id);

                    if ( ! $budgetTag) { // if the tag is new, add it now
                        $budgetTag = new BudgetTag();
                        $budgetTag->budget_id = $this->budget->id;
                        $budgetTag->tag_id = $tag->id;
                        $budgetTag->save();
                    }
                }

                TagTable::cleanUpUnused();
            }

            foreach ($this->budget->Months as $month) {
                $month->calculateCurrent($this->symmetric_key);
            }

            $this->getUser()->setFlash('success', __('The budget was updated successfully!'));

            $this->redirect('@budget_list');
        }
    }

    public function executeDelete(sfWebRequest $request)
    {
        $budget = BudgetTable::fetch($this->user_id, $request->getParameter('id'));

        if ( ! $budget) {
            $this->getUser()->setFlash('error', __('Budget not found.'));
        } else {
            if ($budget->delete()) {
                $this->getUser()->setFlash('success', __('The budget was deleted successfully.'));
            } else {
                $this->getUser()->setFlash('error', __('Failed to delete the budget.'));
            }
        }
        
        $this->redirect('@budget_list');
    }

}

