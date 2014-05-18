<?php

require_once(sfConfig::get('sf_lib_dir').'/filter/base/BaseFormFilterPropel.class.php');

/**
 * User filter form base class.
 *
 * @package    recording
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormFilterGeneratedTemplate.php 16976 2009-04-04 12:47:44Z fabien $
 */
class BaseUserFormFilter extends BaseFormFilterPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'email'            => new sfWidgetFormFilterInput(),
      'display_name'     => new sfWidgetFormFilterInput(),
      'real_name'        => new sfWidgetFormFilterInput(),
      'location'         => new sfWidgetFormFilterInput(),
      'webpage'          => new sfWidgetFormFilterInput(),
      'country'          => new sfWidgetFormFilterInput(),
      'postal_code'      => new sfWidgetFormFilterInput(),
      'birthday'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => true)),
      'gravatar_address' => new sfWidgetFormFilterInput(),
      'info'             => new sfWidgetFormFilterInput(),
      'experience_score' => new sfWidgetFormFilterInput(),
      'up_votes'         => new sfWidgetFormFilterInput(),
      'down_votes'       => new sfWidgetFormFilterInput(),
      'is_guest'         => new sfWidgetFormFilterInput(),
      'is_admin'         => new sfWidgetFormFilterInput(),
      'today_votes'      => new sfWidgetFormFilterInput(),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'user_award_list'  => new sfWidgetFormPropelChoice(array('model' => 'Award', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'email'            => new sfValidatorPass(array('required' => false)),
      'display_name'     => new sfValidatorPass(array('required' => false)),
      'real_name'        => new sfValidatorPass(array('required' => false)),
      'location'         => new sfValidatorPass(array('required' => false)),
      'webpage'          => new sfValidatorPass(array('required' => false)),
      'country'          => new sfValidatorPass(array('required' => false)),
      'postal_code'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'birthday'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'gravatar_address' => new sfValidatorPass(array('required' => false)),
      'info'             => new sfValidatorPass(array('required' => false)),
      'experience_score' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'up_votes'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'down_votes'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_guest'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_admin'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'today_votes'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDate(array('required' => false)))),
      'user_award_list'  => new sfValidatorPropelChoice(array('model' => 'Award', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function addUserAwardListColumnCriteria(Criteria $criteria, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $criteria->addJoin(UserAwardPeer::USER_ID, UserPeer::ID);

    $value = array_pop($values);
    $criterion = $criteria->getNewCriterion(UserAwardPeer::AWARD_ID, $value);

    foreach ($values as $value)
    {
      $criterion->addOr($criteria->getNewCriterion(UserAwardPeer::AWARD_ID, $value));
    }

    $criteria->add($criterion);
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'email'            => 'Text',
      'display_name'     => 'Text',
      'real_name'        => 'Text',
      'location'         => 'Text',
      'webpage'          => 'Text',
      'country'          => 'Text',
      'postal_code'      => 'Number',
      'birthday'         => 'Date',
      'gravatar_address' => 'Text',
      'info'             => 'Text',
      'experience_score' => 'Number',
      'up_votes'         => 'Number',
      'down_votes'       => 'Number',
      'is_guest'         => 'Number',
      'is_admin'         => 'Number',
      'today_votes'      => 'Number',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
      'user_award_list'  => 'ManyKey',
    );
  }
}
