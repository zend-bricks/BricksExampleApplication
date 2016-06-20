<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Api\UserApiInterface;
use Zend\Authentication\AuthenticationService;
use User\Form\LoginForm;

/**
 * User Authentication
 */
class AuthController extends AbstractActionController
{
    protected $api;
    protected $authService;

    public function __construct(UserApiInterface $api, AuthenticationService $authService) {
        $this->api = $api;
        $this->authService = $authService;
    }

    public function loginAction()
    {
        $form = new LoginForm();
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $formData = $form->getData();
                /* @var $adapter \Zend\Authentication\Adapter\AbstractAdapter */
                $adapter = $this->authService->getAdapter();
                $userId = $this->api->getIdByUsername($formData['username']);
                $adapter->setIdentity($userId);
                $adapter->setCredential($formData['password']);
                if ($this->authService->authenticate()) {
                    return $this->redirect()->toRoute('home');
                }
            }
        
        }
        return [
            'form' => $form
        ];
    }
    
    public function logoutAction()
    {
        
    }
    
    public function registerAction()
    {
        
    }
    
    public function confirmRegistrationAction()
    {
        
    }
    
    public function forgotPasswordAction()
    {
        
    }
    
    public function resendRegisterMailAction()
    {
        
    }
    
    public function selfDeleteAction()
    {
        
    }
    
    public function confirmSelfDeleteAction()
    {
        
    }
}
