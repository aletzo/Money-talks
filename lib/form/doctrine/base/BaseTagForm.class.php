<?php

/**
 * Tag form base class.
 *
 * @method Tag getObject() Returns the current form's model object
 *
 * @package    moneytalks
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTagForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'user_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => true)),
      'name'         => new sfWidgetFormInputText(),
      'color'        => new sfWidgetFormInputText(),
      'deleted_at'   => new sfWidgetFormDateTime(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'actions_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Action')),
      'budgets_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'Budget')),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'user_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'required' => false)),
      'name'         => new sfValidatorString(array('max_length' => 100)),
      'color'        => new sfValidatorString(array('max_length' => 6)),
      'deleted_at'   => new sfValidatorDateTime(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'actions_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Action', 'required' => false)),
      'budgets_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'Budget', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tag';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['actions_list']))
    {
      $this->setDefault('actions_list', $this->object->Actions->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['budgets_list']))
    {
      $this->setDefault('budgets_list', $this->object->Budgets->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveActionsList($con);
    $this->saveBudgetsList($con);

    parent::doSave($con);
  }

  public function saveActionsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['actions_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Actions->getPrimaryKeys();
    $values = $this->getValue('actions_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Actions', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Actions', array_values($link));
    }
  }

  public function saveBudgetsList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['budgets_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Budgets->getPrimaryKeys();
    $values = $this->getValue('budgets_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Budgets', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Budgets', array_values($link));
    }
  }

}
