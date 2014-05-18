<?php

/**
 * User form.
 *
 * @package    recording
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class UserForm extends BaseUserForm
{
  public function configure()
  {
  	$this->setWidgets(array(
      'email'            => new sfWidgetFormInput(array(), array("class" => "text")),
      'display_name'     => new sfWidgetFormInput(array(), array("class" => "text")),
      'real_name'        => new sfWidgetFormInput(array(), array("class" => "text")),
      'location'         => new sfWidgetFormInput(array(), array("class" => "text")),
      'webpage'          => new sfWidgetFormInput(array(), array("class" => "text")),
      'country'          => new sfWidgetFormInput(array(), array("class" => "text")),
      'postal_code'      => new sfWidgetFormInput(array(), array("class" => "text")),
      'birthday'         => new sfWidgetFormDate(array(), array("class" => "text", 'rich' => 'true')),
      'info'             => new sfWidgetFormTextarea(array(), array("class" => "textarea", 'rows' => 5, 'cols' => 5)),
    ));

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->setValidators(array(
      'email'            => new sfValidatorEmail(array('max_length' => 64, 'required' => true), array('required' => 'Please provide an email address.  (This will only be used for notification purposes)')),
      'display_name'     => new sfValidatorString(array('required' => true, 'max_length' => 255), array('required' => 'Please provide a display name so we know who you are.')),
      'real_name'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'location'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'webpage'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'country'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'postal_code'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'birthday'         => new sfValidatorDate(array('required' => false), array('bad_format' => 'Make sure your birthday is formatted like MM/DD/YYYY.')),
      'info'             => new sfValidatorString(array('required' => false, 'required' => false)),
    ));

    $defaults = array(
        'email'            => $this->getOption('email', ''),
        'display_name'     => $this->getOption('display_name', ''),
        'real_name'        => $this->getOption('real_name', '')
    );

    $this->setDefaults($defaults);

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
  }
}
