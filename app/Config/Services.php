<?php

namespace Config;

use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function authService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('authService');
        }

        return new \App\Services\Login\AuthService();
    }

    public static function ctoService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('ctoService');
        }

        return new \App\Services\Dashboard\CtoService();
    }

    public static function eventService($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('eventService');
        }

        return new \App\Services\Event\EventService();
    }
}