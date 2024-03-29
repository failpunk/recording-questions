<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * ExperienceTemplates filter form base class.
 *
 * @package    recording
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseExperienceTemplatesFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'experience' => new sfWidgetFormFilterInput(),
      'value'      => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'experience' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'value'      => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('experience_templates_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'ExperienceTemplates';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'experience' => 'Number',
      'value'      => 'Text',
    );
  }
}
