<?php

namespace SoftSmart\SMSPortal;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SoftSmart\SMSPortal\Skeleton\SkeletonClass
 */
class SMSPortalFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SMSPortal';
    }
}
