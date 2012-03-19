<?php

/**
 * BudgetTag form base class.
 *
 * @method BudgetTag getObject() Returns the current form's model object
 *
 * @package    moneytalks
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseBudgetTagForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'budget_id' => new sfWidgetFormInputHidden(),
      'tag_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'budget_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('budget_id')), 'empty_value' => $this->getObject()->get('budget_id'), 'required' => false)),
      'tag_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('tag_id')), 'empty_value' => $this->getObject()->get('tag_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('budget_tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'BudgetTag';
  }

}
