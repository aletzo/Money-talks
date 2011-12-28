<?php

/**
 * Action form base class.
 *
 * @method Action getObject() Returns the current form's model object
 *
 * @package    moneytalks
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseActionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'account_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Account'), 'add_empty' => true)),
      'user_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'name'       => new sfWidgetFormInputText(),
      'date'       => new sfWidgetFormDate(),
      'deposit'    => new sfWidgetFormInputText(),
      'withdrawal' => new sfWidgetFormInputText(),
      'total'      => new sfWidgetFormInputText(),
      'deleted_at' => new sfWidgetFormDateTime(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'account_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Account'), 'required' => false)),
      'user_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 100)),
      'date'       => new sfValidatorDate(),
      'deposit'    => new sfValidatorString(array('max_length' => 100)),
      'withdrawal' => new sfValidatorString(array('max_length' => 100)),
      'total'      => new sfValidatorString(array('max_length' => 100)),
      'deleted_at' => new sfValidatorDateTime(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('action[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Action';
  }

}
