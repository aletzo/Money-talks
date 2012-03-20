<?php

/**
 * BudgetMonth filter form base class.
 *
 * @package    moneytalks
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseBudgetMonthFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'budget_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Budget'), 'add_empty' => true)),
      'current'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'month'     => new sfWidgetFormFilterInput(),
      'year'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'budget_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Budget'), 'column' => 'id')),
      'current'   => new sfValidatorPass(array('required' => false)),
      'month'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'year'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('budget_month_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BudgetMonth';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'budget_id' => 'ForeignKey',
      'current'   => 'Text',
      'month'     => 'Number',
      'year'      => 'Number',
    );
  }
}
