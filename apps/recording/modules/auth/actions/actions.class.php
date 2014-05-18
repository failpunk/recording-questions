<?php

//@TODO Temporary
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

/**
 * openid actions.
 *
 * @package    recording
 * @subpackage openid
 * @author     Valera
 */
class authActions extends BasesfPHPOpenIDAuthActions
{
	/**
	 * Executes index action
	 *
	 * @param sfRequest $request A request object
	 */
	public function executeIndex(sfWebRequest $request)
	{
		$this->error = $this->getRequest()->getErrors();
	}


	private function auth($identifier, $profile)
	{
		$openIdDB = rpxAuthPeer::retriveByIdentifier(md5($identifier));

		if(!$openIdDB)
		{
			$this->initUserSession('unconfirmed');

            // pass some simple user data to the edit user page
            $real_name    = (isset($profile['name']['formatted'])) ? $profile['name']['formatted'] : '';
            $display_name = (isset($profile['displayName'])) ? $profile['displayName'] : '';
            $email        = (isset($profile['email'])) ? $profile['email'] : '';

            $this->getUser()->setFlash('realName', $real_name);
            $this->getUser()->setFlash('displayName', $display_name);
            $this->getUser()->setFlash('email', $email);

			$back = '@profile_edit?identifier='.md5($identifier);
			$this->redirect($back);
		}
		else
		{
			$user = UserPeer::getById( $openIdDB->getUserId() );
            $openIdDB->recordLogin();
            
            if($user->getIsAdmin())
             $this->initUserSession(array('admin', 'user'));
            else
             $this->initUserSession('user');

			myUser::setUserId($openIdDB->getUserId());
			myUser::setOpenId($identifier);

            // redirect to specific page if set, otherwise go back to homepage
            if($this->getUser()->hasAttribute('lastPageUri')) {
                $this->redirect('http://'.$_SERVER['HTTP_HOST'].$this->getUser()->getAttribute('lastPageUri'));
            } else {
                $this->redirect('@homepage');
            }
		}
	}

	private function changeAuth($identifier, $profile)
	{
		$openIdDB = rpxAuthPeer::retriveByIdentifier(md5($identifier));

		if(!$openIdDB)
		{
            $userId = $this->getUser()->getCurrentUser()->getId();

			$authentication = new rpxAuth();
            $authentication->setIdentifier(md5($identifier));
            $authentication->setUserId($userId);
            $authentication->save();

            $this->getUser()->setFlash('authError', 'Your new login has been added.  You can now use the new login service to access your account.');
			$this->redirect(@change_account);
		}
		else
		{
            $this->getUser()->setFlash('authError', 'That login is already being used.');
            $this->redirect('@change_account');
		}
	}


	private function initUserSession($credential)
	{
		$userSession = $this->getUser();
		$userSession->clearCredentials();

		$userSession->setAuthenticated(true);
		$userSession->addCredentials($credential);
	}


	public function executeRPXAuth(sfWebRequest $request)
	{
		$token = $request->getParameter('token');

		if(isset($token))
        {
            $auth_info = rpxAuth::processRpxAuth($token);

             // process the auth_info response
            if ($auth_info['stat'] == 'ok')
            {
                $profile = $auth_info['profile']; // All user's info will be in array $profile

                $identifier = $profile['identifier'];

                $this->auth($identifier, $profile);
            }
            else
            {
                $this->redirect404();
            }
		}

        $this->redirect404();
	}

    public function executeChangeAccount(sfWebRequest $request)
	{
        
    }

    public function executeChangeRPXAuth(sfWebRequest $request)
	{
        $token = $request->getParameter('token');

		if(isset($token))
        {
            $auth_info = rpxAuth::processRpxAuth($token);

             // process the auth_info response
            if ($auth_info['stat'] == 'ok')
            {
                $profile = $auth_info['profile']; // All user's info will be in array $profile

                $identifier = $profile['identifier'];

                $this->changeAuth($identifier, $profile);
            }
            else
            {
                $this->redirect404();
            }
		}
    }

	public function executeLogout()
	{
		$user = $this->getUser();
		$user->setAuthenticated(false);
		$user->clearCredentials();
		$user->setAttribute('userId', null);
		$user->shutdown();

		$back = '@homepage';
		$this->redirect($back);
	}
}
