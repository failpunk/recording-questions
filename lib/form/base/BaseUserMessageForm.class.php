<?php

/**
 * UserMessage form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUserMessageForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'      => new sfWidgetFormInputHidden(),
      'user_id' => new sfWidgetFormInput(),
      'message' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'      => new sfValidatorPropelChoice(array('model' => 'UserMessage', 'column' => 'id', 'required' => false)),
      'user_id' => new sfValidatorInteger(array('required' => false)),
      'message' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_message[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserMessage';
  }


}
