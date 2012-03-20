<?php

/**
 * BudgetMonth form base class.
 *
 * @method BudgetMonth getObject() Returns the current form's model object
 *
 * @package    moneytalks
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBudgetMonthForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'budget_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Budget'), 'add_empty' => true)),
      'current'   => new sfWidgetFormInputText(),
      'month'     => new sfWidgetFormInputText(),
      'year'      => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'budget_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Budget'), 'required' => false)),
      'current'   => new sfValidatorString(array('max_length' => 100)),
      'month'     => new sfValidatorInteger(array('required' => false)),
      'year'      => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('budget_month[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BudgetMonth';
  }

}
