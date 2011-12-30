<?php

/**
 * Action
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    moneytalks
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Action extends BaseAction
{
    
    public function fetchDeposit()
    {
        //TODO: decrypt this
        return $this->deposit;
    }

    public function storeDeposit($deposit)
    {
        //TODO: encrypt this
        $this->deposit = $deposit;
        $this->save();
    }

    public function fetchWithdrawal()
    {
        //TODO: decrypt this
        return $this->withdrawal;
    }

    public function storeWithdrawal($withdrawal)
    {
        //TODO: encrypt this
        $this->withdrawal = $withdrawal;
        $this->save();
    }

    public function fetchBalance()
    {
        //TODO: decrypt this
        return $this->balance;
    }

    public function storeBalance($balance)
    {
        //TODO: encrypt this
        $this->balance = $balance;
        $this->save();
    }

    public function postSave($event)
    {
        $balance = $this->Account->fetchBalance();

        $deposit = $this->fetchDeposit();

        if ($deposit) {
            $balance += $deposit;
        }

        $withdrawal = $this->fetchWithdrawal();

        if ($withdrawal) {
            $balance -= $withdrawal;
        }

        $this->Account->storeBalance($balance);
    }

}