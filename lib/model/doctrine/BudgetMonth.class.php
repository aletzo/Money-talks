<?php

/**
 * BudgetMonth
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    moneytalks
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class BudgetMonth extends BaseBudgetMonth
{
    public function fetchCurrent($key)
    {
        if (empty($this->current)) {
            return 0;
        } else {
            return CryptHelper::getInstance()->setKey($key)
                ->decrypt($this->current);
        }
    }

    public function storeCurrent($current, $key)
    {
        $this->current = CryptHelper::getInstance()->setKey($key)
            ->encrypt($current);

        $this->save();
    }

    public function calculateCurrent($key)
    {
        $tags = array();

        foreach ($this->Budget->Tags as $tag) {
            $tags[] = $tag->id;
        }

        $month = $this->month < 10 ? '0' . $this->month : $this->month;

        $q = Doctrine_Query::create()
            ->from('Action a')
            ->leftJoin('a.Tags t')
            ->andWhere('a.date LIKE ?', '%-' . $month . '-%');

        if ( ! empty($tags)) {
            $q->whereIn('t.id', $tags);
        }

        $results = $q->execute();

        $actions = array();
        
        $tagsCombined = $this->Budget->tags_combined;

        foreach($results as $result) {
            $actionTags = array();
            
            if ($tagsCombined) {
                foreach ($result->Tags as $tag) {
                    $actionTags[] = $tag->id;
                }

                $addAction = true;

                foreach ($tags as $tag) {
                    if ( ! in_array($tag, $actionTags)) {
                        $addAction = false;
                    }
                }
            } else {
                $addAction = true;
            }

            if ($addAction) {
                $actions[] = $result;
            }
            
        }

        $current = 0;
        
        foreach ($actions as $action) {
            $current += $action->fetchWithdrawal($key);
        }

        $this->storeCurrent($current, $key);

        $this->save();
    }

}
