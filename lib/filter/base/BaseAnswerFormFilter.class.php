<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Answer filter form base class.
 *
 * @package    recording
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAnswerFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'question_id' => new sfWidgetFormPropelChoice(array('model' => 'Question', 'add_empty' => true)),
      'answer'      => new sfWidgetFormFilterInput(),
      'offensive'   => new sfWidgetFormFilterInput(),
      'bestAnswer'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'upvotes'     => new sfWidgetFormFilterInput(),
      'downvotes'   => new sfWidgetFormFilterInput(),
      'visible'     => new sfWidgetFormFilterInput(),
      'visited'     => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'question_id' => new sfValidatorPropelChoice(array('required' => false, 'model' => 'Question', 'column' => 'id')),
      'answer'      => new sfValidatorPass(array('required' => false)),
      'offensive'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'bestAnswer'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'upvotes'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'downvotes'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'visible'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'visited'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('answer_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Answer';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'user_id'     => 'ForeignKey',
      'question_id' => 'ForeignKey',
      'answer'      => 'Text',
      'offensive'   => 'Number',
      'bestAnswer'  => 'Boolean',
      'upvotes'     => 'Number',
      'downvotes'   => 'Number',
      'visible'     => 'Number',
      'visited'     => 'Number',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
