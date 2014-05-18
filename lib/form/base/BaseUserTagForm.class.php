<?php

/**
 * UserTag form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUserTagForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'tag_id'   => new sfWidgetFormPropelChoice(array('model' => 'Tag', 'add_empty' => false)),
      'user_id'  => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'positive' => new sfWidgetFormInputCheckbox(),
      'negative' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorPropelChoice(array('model' => 'UserTag', 'column' => 'id', 'required' => false)),
      'tag_id'   => new sfValidatorPropelChoice(array('model' => 'Tag', 'column' => 'id')),
      'user_id'  => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'positive' => new sfValidatorBoolean(array('required' => false)),
      'negative' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_tag[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserTag';
  }


}
