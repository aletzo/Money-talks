<?php

require_once sfConfig::get('sf_plugins_dir') . '/sfDoctrineGuardPlugin/modules/sfGuardAuth/lib/BasesfGuardAuthActions.class.php';

class sfGuardAuthActions extends BasesfGuardAuthActions
{

    public function executeSignin($request)
    {
        $user = $this->getUser();
        if ($user->isAuthenticated()) {
            return $this->redirect('@homepage');
        }

        $class = sfConfig::get('app_sf_guard_plugin_signin_form', 'sfGuardFormSignin');
        $this->form = new $class();

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('signin'));
            if ($this->form->isValid()) {
                $values = $this->form->getValues();
                $this->getUser()->signin($values['user'], array_key_exists('remember', $values) ? $values['remember'] : false);

                return $this->redirect('@homepage');
            }
        } else {
            if ($request->isXmlHttpRequest()) {
                $this->getResponse()->setHeaderOnly(true);
                $this->getResponse()->setStatusCode(401);

                return sfView::NONE;
            }

            // if we have been forwarded, then the referer is the current URL
            // if not, this is the referer of the current request
            $user->setReferer($this->getContext()->getActionStack()->getSize() > 1 ? $request->getUri() : $request->getReferer());

            $module = sfConfig::get('sf_login_module');
            if ($this->getModuleName() != $module) {
                return $this->redirect($module . '/' . sfConfig::get('sf_login_action'));
            }

            $this->getResponse()->setStatusCode(401);
        }
    }

    public function executeSignout($request)
    {
        $this->getUser()->setAuthenticated(false);
        $this->getUser()->signOut();

        session_destroy();
        session_write_close();
        session_regenerate_id();
 
        $this->redirect('@homepage');
    }
    
    public function executeLogin(sfWebRequest $request)
    {
        if ($this->getUser()->isAuthenticated()) {
            $this->redirect('@homepage');
        }
        
        $openid = new LightOpenID($request->getHost());
        
        if (!$openid->mode) {
            if ($request->isMethod('post')) {
                switch ($request->getPostParameter('provider')) {
                    case 'google':
                        $openid->identity = 'https://www.google.com/accounts/o8/id';
                        break;
                    case 'local':
                        $openid->identity = 'http://myopenid.local/MyID.config.php';
                        break;
                    case 'yahoo':
                        $openid->identity = 'https://me.yahoo.com';
                        break;
                    default:
                        $this->getUser()->setFlash('error', 'Invalid provider');
                        
                        $this->redirect('@sf_guard_signin');
                        break;
                }
                
                $openid->required = array('contact/email');

                $this->redirect($openid->authUrl());
            }
        } elseif ($openid->mode == 'cancel') {
            $this->getUser()->setFlash('warning', 'You canceled the authentication!');

            $this->redirect('@sf_guard_signin');
        } else {
            if ($openid->validate()) {
                $openidAttributes = $openid->getAttributes();
                
                $user = sfGuardUserTable::getInstance()->findOneByEmail_address($openidAttributes['contact/email']);
                
                if (!$user) {
                    $newUser = new sfGuardUser();
                    $newUser->username = $openidAttributes['contact/email'];
                    $newUser->email_address = $openidAttributes['contact/email'];
                    $newUser->is_active = true;
                    $newUser->save();
                    
                    $authUser = $newUser;
                } else {
                    $authUser = $user;
                }
                
                $this->getUser()->signin($authUser);
                
                $this->getUser()->setAuthenticated(true);
                
                $this->getUser()->setAttribute('attributes', $openidAttributes, 'openid');
                
                $this->getUser()->setFlash('success', 'You were authenticated successfully!');

                $this->redirect('@homepage');
            } else {
                $this->getUser()->setFlash('error', 'Failed to authenticate! Please try again or choose a different OpenID provider.');

                $this->redirect('@sf_guard_signin');
            }
        }
    }

}
