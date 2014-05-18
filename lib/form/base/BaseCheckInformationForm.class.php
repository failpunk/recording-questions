<?php

/**
 * CheckInformation form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCheckInformationForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'user_id'        => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'information_id' => new sfWidgetFormPropelChoice(array('model' => 'InformationTemplates', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorPropelChoice(array('model' => 'CheckInformation', 'column' => 'id', 'required' => false)),
      'user_id'        => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id', 'required' => false)),
      'information_id' => new sfValidatorPropelChoice(array('model' => 'InformationTemplates', 'column' => 'id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('check_information[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CheckInformation';
  }


}
