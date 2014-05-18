<?php

/**
 * Award form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAwardForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'name'            => new sfWidgetFormInput(),
      'description'     => new sfWidgetFormInput(),
      'created_at'      => new sfWidgetFormDateTime(),
      'user_award_list' => new sfWidgetFormPropelChoiceMany(array('model' => 'User')),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorPropelChoice(array('model' => 'Award', 'column' => 'id', 'required' => false)),
      'name'            => new sfValidatorString(array('max_length' => 25, 'required' => false)),
      'description'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'      => new sfValidatorDateTime(),
      'user_award_list' => new sfValidatorPropelChoiceMany(array('model' => 'User', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('award[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Award';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_award_list']))
    {
      $values = array();
      foreach ($this->object->getUserAwards() as $obj)
      {
        $values[] = $obj->getUserId();
      }

      $this->setDefault('user_award_list', $values);
    }

  }

  protected function doSave($con = null)
  {
    parent::doSave($con);

    $this->saveUserAwardList($con);
  }

  public function saveUserAwardList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['user_award_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (is_null($con))
    {
      $con = $this->getConnection();
    }

    $c = new Criteria();
    $c->add(UserAwardPeer::AWARD_ID, $this->object->getPrimaryKey());
    UserAwardPeer::doDelete($c, $con);

    $values = $this->getValue('user_award_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserAward();
        $obj->setAwardId($this->object->getPrimaryKey());
        $obj->setUserId($value);
        $obj->save();
      }
    }
  }

}
