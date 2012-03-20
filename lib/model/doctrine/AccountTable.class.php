<?php

/**
 * AccountTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AccountTable extends Doctrine_Table
{

    /**
     * Returns an instance of this class.
     *
     * @return object AccountTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Account');
    }

    static public function fetch($userId, $accountId = false, $deep = false, $toArray = false)
    {
        $q = Doctrine_Query::create()
            ->from('Account a')
            ->andWhere('a.user_id = ?', $userId)
            ->andWhere('a.deleted_at is null'); //softdelete

        if ($accountId) {
            $q->where('a.id = ?', $accountId);
        }

        if ($deep) {
            $q ->leftJoin('a.Actions c')
                ->leftJoin('c.Tags t')
                ->andWhere('c.deleted_at is null') //softdelete
                ->andWhere('t.deleted_at is null'); //softdelete
        }

        if ($toArray) {
            $q->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
        }

        return $accountId ? $q->fetchOne() : $q->execute();
    }

    static public function filterAccountActions($accountId, $history, $deposit, $withdrawal)
    {
        $timestamp = time() - (2592000 * $history); // 30 * 24 * 60 * 60,  $history is in months

        $q = Doctrine_Query::create()
            ->from('Action a')
            ->where('a.account_id = ?', $accountId)
            ->andWhere('a.date > ?', date('Y-m-d 0:00:00', $timestamp))
            ->andWhere('a.deleted_at is null');

        if ($deposit && $withdrawal) {
            $extraWhere = "a.deposit <> '' OR a.withdrawal <> ''";
        } elseif ($deposit) {
            $extraWhere = "a.deposit <> ''";
        } elseif ($withdrawal) {
            $extraWhere = "a.withdrawal <> ''";
        } else {
            $extraWhere = "a.deposit = '' AND a.withdrawal = ''";
        }
        
        $q->andWhere($extraWhere);

        return $q->execute();
    }

}
