<?php

namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

class Module
{
    const VERSION = '1.0.0';

    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
    
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        
        $eventManager->attach(MvcEvent::EVENT_ROUTE, [$this, 'prepareTranslator']);
    }
    
    public function prepareTranslator(MvcEvent $e)
    {
        /* @var $container \Interop\Container\ContainerInterface */
        $container = $e->getApplication()->getServiceManager();
        /* @var $translator \Zend\I18n\Translator\Translator */
        $translator = $container->get('translator');
        
        $host = $e->getRouter()->getRequestUri()->getHost();
        $language = substr($host, 0, strpos($host, '.'));
        if (strlen($language) != 2) {
            $languageHeader = $e->getRequest()->getHeader('Accept-Language');
            $preferedLanguage = $languageHeader->getPrioritized();
            /* @var $preferedLanguage \Zend\Http\Header\Accept\FieldValuePart\LanguageFieldValuePart */
            $preferedLanguage = reset($preferedLanguage);
            $language = $preferedLanguage->getLanguage();
        }
        $translator->setLocale($language);
        $translator->setCache($container->get('TranslatorCache'));
        \Locale::setDefault($language);
//        AbstractValidator::setDefaultTranslator($translator, 'default');
    }
}
