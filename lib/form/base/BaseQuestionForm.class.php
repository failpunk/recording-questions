<?php

/**
 * Question form base class.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseQuestionForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'user_id'     => new sfWidgetFormPropelChoice(array('model' => 'User', 'add_empty' => false)),
      'tag_id'      => new sfWidgetFormInput(),
      'title'       => new sfWidgetFormInput(),
      'description' => new sfWidgetFormTextarea(),
      'offensive'   => new sfWidgetFormInput(),
      'visible'     => new sfWidgetFormInput(),
      'locked'      => new sfWidgetFormInput(),
      'upvotes'     => new sfWidgetFormInput(),
      'downvotes'   => new sfWidgetFormInput(),
      'visited'     => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorPropelChoice(array('model' => 'Question', 'column' => 'id', 'required' => false)),
      'user_id'     => new sfValidatorPropelChoice(array('model' => 'User', 'column' => 'id')),
      'tag_id'      => new sfValidatorInteger(array('required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('required' => false)),
      'offensive'   => new sfValidatorInteger(),
      'visible'     => new sfValidatorInteger(),
      'locked'      => new sfValidatorInteger(),
      'upvotes'     => new sfValidatorInteger(),
      'downvotes'   => new sfValidatorInteger(),
      'visited'     => new sfValidatorInteger(),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('question[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Question';
  }


}
