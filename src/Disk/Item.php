<?php

namespace MSAR\MediaManager\Disk;

use Illuminate\Support\Str;

/**
 * Class Item
 * 
 * @method string getPath() getPath() Get the path of the item.
 * @method string getTimestamp() getTimestamp() Get the timestamp of the item.
 * @method string getDirname() getDirname() Get the dirname of the item.
 * @method string getBasename() getBasename() Get the basename of the item.
 * @method string getFilename() getFilename() Get the filename of the item.
 * @method string getType() getType() Get the type of the item.
 * @method string getExtension() getExtension() Get the extension of the item.
 * @method string getSize() getSize() Get the size of the item.
 */
abstract class Item
{
    /**
     * @var string The type of the item.
     */
    public $type;

    /**
     * @var string The path of the item.
     */
    public $path;

    /**
     * @var string The timestamp of the item.
     */
    public $timestamp;

    /**
     * @var string The dirname of the item.
     */
    public $dirname;

    /**
     * @var string The basename of the item.
     */
    public $basename;

    /**
     * @var string The filename of the item.
     */
    public $filename;

    /**
     * Create a new item instance.
     * 
     * @param array $info The info of the item.
     */
    public function __construct(array $info = [])
    {
        $this->path         = $info['path'] ?? null;
        $this->timestamp    = $info['timestamp'] ?? null;
        $this->dirname      = $info['dirname'] ?? null;
        $this->basename     = $info['basename'] ?? null;
        $this->filename     = $info['filename'] ?? null;
    }

    /**
     * Set info of the item.
     * 
     * @param array $info The info of the item.
     * @return void
     */
    public function setAll(array $info = [])
    {
        foreach ($info as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Get the items in array.
     * 
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->getModelProperties(), JSON_THROW_ON_ERROR);
    }

    /**
     * Get the items in array.
     * 
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->getModelProperties();
    }

    /**
     * Get access to private model properties via PHP Reflection
     *
     * @return array<string, mixed>
     */
    protected function getModelProperties(): array
    {
        $reflector = new \ReflectionClass($this);
        $properties = [
            ...$reflector->getProperties(),
            ...($reflector->getParentClass() !== false ? $reflector->getParentClass()->getProperties() : [])
        ];

        $vars = [];

        foreach ($properties as $prop) {
            $vars[$prop->name] = $this->{"get" . ucfirst($prop->name)}();
        }

        return $vars;
    }

    /**
     * Call a method of the item.
     * 
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this, $name], $arguments);
        }

        if( Str::startsWith($name, 'get') ) {
            $name = strtolower(substr($name, 3));
            return $this->$name;
        }
        
        if( Str::startsWith($name, 'set') ) {
            $name = strtolower(substr($name, 3));
            return $this->$name = $arguments[0];
        }
    }
}
