<?php

/**
 * CustomTemplates form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseCustomTemplatesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'    => new sfWidgetFormInputHidden(),
      'name'  => new sfWidgetFormInput(),
      'value' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'    => new sfValidatorPropelChoice(array('model' => 'CustomTemplates', 'column' => 'id', 'required' => false)),
      'name'  => new sfValidatorString(array('max_length' => 256, 'required' => false)),
      'value' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('custom_templates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CustomTemplates';
  }


}
