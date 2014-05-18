<?php

/**
 * QuestionComment form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseQuestionCommentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'description' => new sfWidgetFormInput(),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'question_id' => new sfWidgetFormPropelChoice(array('model' => 'Question', 'add_empty' => false)),
      'created_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'QuestionComment', 'column' => 'id', 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'question_id' => new sfValidatorPropelChoice(array('model' => 'Question', 'column' => 'id')),
      'created_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('question_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'QuestionComment';
  }


}
