<?php

/**
 * BaseAccount
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $name
 * @property string $total
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Actions
 * 
 * @method integer             getUserId()  Returns the current record's "user_id" value
 * @method string              getName()    Returns the current record's "name" value
 * @method string              getTotal()   Returns the current record's "total" value
 * @method sfGuardUser         getUser()    Returns the current record's "User" value
 * @method Doctrine_Collection getActions() Returns the current record's "Actions" collection
 * @method Account             setUserId()  Sets the current record's "user_id" value
 * @method Account             setName()    Sets the current record's "name" value
 * @method Account             setTotal()   Sets the current record's "total" value
 * @method Account             setUser()    Sets the current record's "User" value
 * @method Account             setActions() Sets the current record's "Actions" collection
 * 
 * @package    moneytalks
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAccount extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('account');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('total', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));

        $this->option('type', 'InnoDB');
        $this->option('collate', 'utf8_unicode_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('Action as Actions', array(
             'local' => 'id',
             'foreign' => 'account_id'));

        $softdelete0 = new Doctrine_Template_SoftDelete();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($softdelete0);
        $this->actAs($timestampable0);
    }
}