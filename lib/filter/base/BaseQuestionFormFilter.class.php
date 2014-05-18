<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * Question filter form base class.
 *
 * @package    recording
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseQuestionFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => true)),
      'tag_id'      => new sfWidgetFormFilterInput(),
      'title'       => new sfWidgetFormFilterInput(),
      'description' => new sfWidgetFormFilterInput(),
      'offensive'   => new sfWidgetFormFilterInput(),
      'visible'     => new sfWidgetFormFilterInput(),
      'locked'      => new sfWidgetFormFilterInput(),
      'upvotes'     => new sfWidgetFormFilterInput(),
      'downvotes'   => new sfWidgetFormFilterInput(),
      'visited'     => new sfWidgetFormFilterInput(),
      'created_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'  => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'user_id'     => new sfValidatorPropelChoice(array('required' => false, 'model' => 'User', 'column' => 'id')),
      'tag_id'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'title'       => new sfValidatorPass(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'offensive'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'visible'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'locked'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'upvotes'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'downvotes'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'visited'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'  => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
    ));

    $this->widgetSchema->setNameFormat('question_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Question';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'user_id'     => 'ForeignKey',
      'tag_id'      => 'Number',
      'title'       => 'Text',
      'description' => 'Text',
      'offensive'   => 'Number',
      'visible'     => 'Number',
      'locked'      => 'Number',
      'upvotes'     => 'Number',
      'downvotes'   => 'Number',
      'visited'     => 'Number',
      'created_at'  => 'Date',
      'updated_at'  => 'Date',
    );
  }
}
