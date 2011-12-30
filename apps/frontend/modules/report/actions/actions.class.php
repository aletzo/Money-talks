<?php

/**
 * report actions.
 *
 * @package    moneytalks 
 * @subpackage report
 * @author     ajo@mydevnull.net
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reportActions extends sfActions
{
    protected $user_id = null;

    public function preExecute()
    {
        parent::preExecute();

        $this->user_id = $this->getUser()->getGuardUser()->id;
    }

    public function executeList(sfWebRequest $request)
    {
        $this->getUser()->setHeader('Reports');

        $accounts = AccountTable::fetch($this->user_id, false, true, false);

        $this->string = 'Tags';
        $this->number = 'Money';

        $depositPie = array();

        $withdrawalPie = array();

        $this->deposits = 0;
        $this->withdrawals = 0;

        foreach ($accounts as $account) {
            foreach ($account->Actions as $action) {
                $deposit = $action->fetchDeposit();
                $withdrawal = $action->fetchWithdrawal();

                $tagsCount = count($action->Tags);

                $depositSlice = $deposit > 0 ? $deposit / $tagsCount : 0;

                $this->deposits += $depositSlice;

                $withdrawalSlice = $withdrawal > 0 ? $withdrawal / $tagsCount : 0;

                $this->withdrawals += $withdrawalSlice;

                foreach ($action->Tags as $tag) {
                    $tagName = $tag->name;
                    
                    if ($depositSlice) {
                        if (array_key_exists($tagName, $depositPie)) {
                            $depositPie[$tagName] += $depositSlice;
                        } else {
                            $depositPie[$tagName] = $depositSlice;
                        }
                    }

                    if ($withdrawalSlice) {
                        if (array_key_exists($tagName, $withdrawalPie)) {
                            $withdrawalPie[$tagName] += $withdrawalSlice;
                        } else {
                            $withdrawalPie[$tagName] = $withdrawalSlice;
                        }
                    }

                }
            }
        }

        $this->deposit_pie = $depositPie;
        $this->withdrawal_pie = $withdrawalPie;
    }

}

