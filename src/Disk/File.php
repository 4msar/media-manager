<?php 

namespace MSAR\MediaManager\Disk;

class File extends Item
{
    /**
     * @var string The type of the file.
     */
    public $type = 'file';

    /**
     * @var string The size of the file.
     */
    public $size;

    /**
     * @var string The extension of the file.
     */
    public $extension;

    /**
     * Create a new file instance.
     * 
     * @param array $info The info of the file
     */
    public function __construct(array $info = [])
    {
        parent::__construct($info);
        $this->size         = $info['size'] ?? null;
        $this->extension    = $info['extension'] ?? null;
    }
}
