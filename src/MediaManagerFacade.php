<?php

namespace MSAR\MediaManager;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MSAR\MediaManager\MediaManager class
 */
class MediaManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'media-manager';
    }
}
