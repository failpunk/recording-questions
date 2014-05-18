<?php

/**
 * User form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUserForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'email'            => new sfWidgetFormInput(),
      'display_name'     => new sfWidgetFormInput(),
      'real_name'        => new sfWidgetFormInput(),
      'location'         => new sfWidgetFormInput(),
      'webpage'          => new sfWidgetFormInput(),
      'country'          => new sfWidgetFormInput(),
      'postal_code'      => new sfWidgetFormInput(),
      'birthday'         => new sfWidgetFormDateTime(),
      'gravatar_address' => new sfWidgetFormInput(),
      'info'             => new sfWidgetFormTextarea(),
      'experience_score' => new sfWidgetFormInput(),
      'up_votes'         => new sfWidgetFormInput(),
      'down_votes'       => new sfWidgetFormInput(),
      'is_guest'         => new sfWidgetFormInput(),
      'is_admin'         => new sfWidgetFormInput(),
      'today_votes'      => new sfWidgetFormInput(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'user_award_list'  => new sfWidgetFormPropelChoiceMany(array('model' => 'Award')),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'email'            => new sfValidatorString(array('max_length' => 64)),
      'display_name'     => new sfValidatorString(array('max_length' => 255)),
      'real_name'        => new sfValidatorString(array('max_length' => 255)),
      'location'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'webpage'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postal_code'      => new sfValidatorInteger(array('required' => false)),
      'birthday'         => new sfValidatorDateTime(array('required' => false)),
      'gravatar_address' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'info'             => new sfValidatorString(array('required' => false)),
      'experience_score' => new sfValidatorInteger(),
      'up_votes'         => new sfValidatorInteger(),
      'down_votes'       => new sfValidatorInteger(),
      'is_guest'         => new sfValidatorInteger(),
      'is_admin'         => new sfValidatorInteger(),
      'today_votes'      => new sfValidatorInteger(),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'user_award_list'  => new sfValidatorPropelChoiceMany(array('model' => 'Award', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }


  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['user_award_list']))
    {
      $values = array();
      foreach ($this->object->getUserAwards() as $obj)
      {
        $values[] = $obj->getAwardId();
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
    $c->add(UserAwardPeer::USER_ID, $this->object->getPrimaryKey());
    UserAwardPeer::doDelete($c, $con);

    $values = $this->getValue('user_award_list');
    if (is_array($values))
    {
      foreach ($values as $value)
      {
        $obj = new UserAward();
        $obj->setUserId($this->object->getPrimaryKey());
        $obj->setAwardId($value);
        $obj->save();
      }
    }
  }

}
