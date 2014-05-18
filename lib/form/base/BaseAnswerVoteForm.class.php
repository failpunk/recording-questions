<?php

/**
 * AnswerVote form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAnswerVoteForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'user_id'    => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'answer_id'  => new sfWidgetFormPropelChoice(array('model' => 'Answer', 'add_empty' => false)),
      'weight'     => new sfWidgetFormInput(),
      'positive'   => new sfWidgetFormInputCheckbox(),
      'negative'   => new sfWidgetFormInputCheckbox(),
      'created_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorPropelChoice(array('model' => 'AnswerVote', 'column' => 'id', 'required' => false)),
      'user_id'    => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'answer_id'  => new sfValidatorPropelChoice(array('model' => 'Answer', 'column' => 'id')),
      'weight'     => new sfValidatorInteger(),
      'positive'   => new sfValidatorBoolean(array('required' => false)),
      'negative'   => new sfValidatorBoolean(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('answer_vote[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'AnswerVote';
  }


}
