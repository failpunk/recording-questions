<?php

/**
 * ExperienceTemplates form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseExperienceTemplatesForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'experience' => new sfWidgetFormInput(),
      'value'      => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'ExperienceTemplates', 'column' => 'id', 'required' => false)),
      'experience' => new sfValidatorInteger(array('required' => false)),
      'value'      => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('experience_templates[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExperienceTemplates';
  }


}
