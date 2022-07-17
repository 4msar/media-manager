<?php

namespace MSAR\MediaManager\Disk;

class Folder extends Item
{
    /**
     * @var string The type of the file.
     */
    public $type = 'dir';

    /**
     * Create a new folder instance.
     * 
     * @param array $info The info of the folder.
     */
    public function __construct(array $info = [])
    {
        parent::__construct($info);
    }
}
