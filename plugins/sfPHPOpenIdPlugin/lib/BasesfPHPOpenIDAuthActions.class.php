<?php

/*
 * This file is part of the symfony package.
 * (c) 2007 Dave Dash <dave.dash@spindrop.us>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Dave Dash <dave.dash@spindrop.us>
 */
class BasesfPHPOpenIDAuthActions extends sfActions
{
	/* This is the form... the guts in the template file can 	be copied and pasted without much worry. */
	public function executeSignin()
	{
		if ($this->isPost()) { // Form validated
			return $this->signinProcedure($this->getRequestParameter('openid_url'));
		}
		return sfView::NONE;
	}

 /**
  * Execute an autosignin
  *
  * The user identity must be passed as 'openid_url' attribute
  */
  public function executeAutoSignin() {
    $id = $this->getUser()->getAttribute('openid_url');
    $this->getUser()->getAttributeHolder()->remove('openid_url');
    if (!empty($id)) {
			return $this->signinProcedure($id, true);
    }
		return sfView::NONE;
  }

  public function signinProcedure($identity, $immediate = false) {
	  $openid = new sfPHPOpenID();
		$openid->setIdentity($identity);

		$process_url = $this->getController()->genUrl('@openid_finishauth', true);
		$openid->setApprovedURL($process_url); // Script which handles a response from OpenID Server

		$trust_root = $this->getController()->genUrl('@homepage', true);
		$openid->SetTrustRoot($trust_root);

		$this->setOpenIDRequestParameters($openid); // Call a function to customize the openid object from the app

		$nextStep = $openid->getRedirectURL($immediate);

		if (($nextStep['type'] == 'url') && (!empty($nextStep['content']))) {
		  // If we're using AJAX, a normal redirect would have no effect. So use a bit of javascript
		  if ($this->getRequest()->isXmlHttpRequest()) {
		    $this->renderText("<script type=\"text/javascript\">var transiting = true;document.location.href = \"".$nextStep['content']."\"</script>");
		    return sfView::NONE;
		  }
		  else {
		    $this->redirect($nextStep['content']); // redirect to provider url
		  }
		}
		else if (($nextStep['type'] == 'form') && (!empty($nextStep['content']))) {
		  // render an autosubmit form
		  if ($this->getRequest()->isXmlHttpRequest()) { // If we're using AJAX, a normal redirect would have no effect. So use a bit of javascript
		    $this->renderText($nextStep['content']);
		    $this->renderText("<script type=\"text/javascript\">var transiting = true;document.getElementById('openid_message').submit();</script>");
		  }
		  else {
		    // This is not AJAX. So display a button to be clicked by the user if javascript is disabled. Else wait for auto submiting.
		    $this->renderText("<h2>Authentication in progress (with OpenID: $identity).</h2>");
		    $this->renderText($nextStep['content']);
		    $this->renderText("<script type=\"text/javascript\">document.getElementById('openid_message').style.display = 'none';</script>");
		  }

		  return sfView::NONE;
		}
		else {
		  // Show an error message
		  if (empty($nextStep['content']))
		    $error = "Unexpected error.";
		  else
			  $error = $nextStep['content'];

            $this->getRequest()->setError('openid_url', $error);

			$routes = sfContext::getInstance()->getRouting()->getRoutes();
			$route = $routes['openid_error']->getDefaults();
			$this->forward($route['module'], $route['action']);
		}
  }

  // Override this method in your app if you want to add parameters to the openid request
  // For example, adding fields to request like nickname or date of birth.
  protected function setOpenIDRequestParameters(sfPHPOpenID $openid_object) {
    /*
    // This is an example of code you can write in your app
    $openid_object->setRequestFields(array('nickname'));
    */
  }

	public function handleErrorSignin()
	{
		$routes = sfContext::getInstance()->getRouting()->getRoutes();
		$route = $routes['openid_error']->getDefaults();
		$this->forward($route['module'], $route['action']);
	}

	public function executeFinish()
	{
    $openid = new sfPHPOpenID();
    $openid->setIdentity($this->getRequestParameter('openid_identity'));

		$process_url = $this->getController()->genUrl('@openid_finishauth', true);
		$openid->setApprovedURL($process_url); // Script which handles a response from OpenID Server

		$trust_root = $this->getController()->genUrl('@homepage', true);
		$openid->SetTrustRoot($trust_root);

    $openid_validation_result = $openid->getAuthResult();

    if ($openid_validation_result['result'] == sfPHPOpenID::AUTH_SUCCESS) {
      $this->openIDCallback($openid_validation_result);
    }
    else {
      if (!empty($openid_validation_result['message']))
        $this->getRequest()->setError('openid_url', $openid_validation_result['message']);
		  $routes = sfContext::getInstance()->getRouting()->getRoutes();
		  $route = $routes['openid_error']->getDefaults();
		  $this->forward($route['module'], $route['action']);
    }
	}

	public function isPost()
	{
		return ($this->getRequest()->getMethod() == sfRequest::POST);
	}

	public function openIDCallback($openid_validation_result)
	{
	}
}
