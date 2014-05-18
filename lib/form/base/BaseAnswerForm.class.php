<?php

/**
 * Answer form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseAnswerForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'question_id' => new sfWidgetFormPropelChoice(array('model' => 'Question', 'add_empty' => false)),
      'answer'      => new sfWidgetFormTextarea(),
      'offensive'   => new sfWidgetFormInput(),
      'bestAnswer'  => new sfWidgetFormInputCheckbox(),
      'upvotes'     => new sfWidgetFormInput(),
      'downvotes'   => new sfWidgetFormInput(),
      'visible'     => new sfWidgetFormInput(),
      'visited'     => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Answer', 'column' => 'id', 'required' => false)),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'question_id' => new sfValidatorPropelChoice(array('model' => 'Question', 'column' => 'id')),
      'answer'      => new sfValidatorString(),
      'offensive'   => new sfValidatorInteger(),
      'bestAnswer'  => new sfValidatorBoolean(),
      'upvotes'     => new sfValidatorInteger(),
      'downvotes'   => new sfValidatorInteger(),
      'visible'     => new sfValidatorInteger(),
      'visited'     => new sfValidatorInteger(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('answer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Answer';
  }


}
