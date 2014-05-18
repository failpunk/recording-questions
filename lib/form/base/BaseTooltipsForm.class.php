<?php

/**
 * Tooltips form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseTooltipsForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'key'   => new sfWidgetFormInput(),
      'value' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorPropelChoice(array('model' => 'Tooltips', 'column' => 'id', 'required' => false)),
      'key'   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'value' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('tooltips[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tooltips';
  }


}
