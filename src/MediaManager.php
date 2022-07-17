<?php

namespace MSAR\MediaManager;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MediaManager
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected $disk;

    /**
     * @var array
     */
    protected $config;

    public function __construct($config = [])
    {
        $this->config = array_merge([
            'show_hidden' => false,
            'recursive' => false,
            'disk' => 'public',
        ], $config);
        $this->disk = Storage::disk($this->config['disk'] ?? 'public');
    }

    public function getDisk()
    {
        return $this->disk;
    }

    public function setDisk($disk)
    {
        $this->disk = $disk;
    }

    /**
     * Get all items in the given directory.
     *
     * @param string $path
     * @return Collection|array<File|Folder>
     */
    public function getAllItems($path = '/')
    {
        $items = $this->getDisk()->listContents($path, $this->config['recursive']);

        return (new Collection($items))
                ->filter(function ($item) {
                    // Filter out the hidden files and directories.
                    if (!$this->config['show_hidden'] && $item['basename'][0] === '.') {
                        return false;
                    }
                    return true;
                })
                ->sortBy(['name', 'type'])
                ->map(function ($item) {
                    return $this->createItem($item);
                });
    }

    protected function createItem($item)
    {
        if ($item['type'] === 'file') {
            return new Disk\File($item);
        }

        return new Disk\Folder($item);
    }
}
