<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * UserTag filter form base class.
 *
 * @package    recording
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUserTagFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'tag_id'   => new sfWidgetFormPropelChoice(array('model' => 'Tag', 'add_empty' => true)),
      'user_id'  => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'positive' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'negative' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'tag_id'   => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Tag', 'column' => 'id')),
      'user_id'  => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'positive' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'negative' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('user_tag_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'UserTag';
  }

  public function getFields()
  {
    return array(
      'id'       => 'Number',
      'tag_id'   => 'ForeignKey',
      'user_id'  => 'ForeignKey',
      'positive' => 'Boolean',
      'negative' => 'Boolean',
    );
  }
}
