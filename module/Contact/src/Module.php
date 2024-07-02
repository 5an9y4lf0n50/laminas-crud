<?php

namespace Contact;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\EventManager\EventInterface as Event;
use Laminas\ModuleManager\ModuleManager;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(Event $e)
    {
        // This method is called once the MVC bootstrapping is complete
        $moduleManager = $e->getTarget();
        $application = $e->getApplication();
        $services    = $application->getServiceManager();
        $config = $moduleManager->getConfig();
        $timezone = isset($config["timezone"]) ? $config["timezone"] : "UTC";
        date_default_timezone_set($timezone);
    }
}