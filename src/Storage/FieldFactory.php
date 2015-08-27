<?php
namespace Bolt\Storage;

use Bolt\Storage\Field\Type\FieldTypeInterface;

/**
 * Uses a typemap to construct an instance of a Field 
 */
class FieldFactory
{
    /** @var array */
    protected $typemap;
    protected $handlers = [];
    

    /**
     * Constructor.
     *
     * @param array $typemap
     */
    public function __construct(array $typemap)
    {
        $this->typemap = $typemap;
    }
    
    public function get($class, $mapping)
    {
        if (is_object($class)) {
            $class = get_class($class);
        }
        if (array_key_exists($class, $this->handlers)) {
            $handler = $this->handlers[$class];
            return call_user_func_array($handler, [$mapping]);
        }
        
        return new $class($mapping);
    }
    
    public function setHandler($class, callable $handler)
    {
        $this->handlers[$class] = $handler;
    }


}
