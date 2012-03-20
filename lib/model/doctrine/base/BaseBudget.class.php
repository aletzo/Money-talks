<?php

/**
 * BaseBudget
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $amount
 * @property boolean $tags_combined
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Tags
 * @property Doctrine_Collection $Months
 * @property Doctrine_Collection $BudgetTag
 * 
 * @method integer             getUserId()        Returns the current record's "user_id" value
 * @method string              getAmount()        Returns the current record's "amount" value
 * @method boolean             getTagsCombined()  Returns the current record's "tags_combined" value
 * @method sfGuardUser         getUser()          Returns the current record's "User" value
 * @method Doctrine_Collection getTags()          Returns the current record's "Tags" collection
 * @method Doctrine_Collection getMonths()        Returns the current record's "Months" collection
 * @method Doctrine_Collection getBudgetTag()     Returns the current record's "BudgetTag" collection
 * @method Budget              setUserId()        Sets the current record's "user_id" value
 * @method Budget              setAmount()        Sets the current record's "amount" value
 * @method Budget              setTagsCombined()  Sets the current record's "tags_combined" value
 * @method Budget              setUser()          Sets the current record's "User" value
 * @method Budget              setTags()          Sets the current record's "Tags" collection
 * @method Budget              setMonths()        Sets the current record's "Months" collection
 * @method Budget              setBudgetTag()     Sets the current record's "BudgetTag" collection
 * 
 * @package    moneytalks
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBudget extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('budget');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('amount', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('tags_combined', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
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

        $this->hasMany('Tag as Tags', array(
             'refClass' => 'BudgetTag',
             'local' => 'budget_id',
             'foreign' => 'tag_id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('BudgetMonth as Months', array(
             'local' => 'id',
             'foreign' => 'budget_id'));

        $this->hasMany('BudgetTag', array(
             'local' => 'id',
             'foreign' => 'budget_id'));

        $softdelete0 = new Doctrine_Template_SoftDelete();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($softdelete0);
        $this->actAs($timestampable0);
    }
}