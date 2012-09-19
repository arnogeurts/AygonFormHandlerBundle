<?php

namespace Aygon\FormHandlerBundle\Form\Handler;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Arno Geurts 
 */
class FormHandlerManager
{
    /**
     * The DI container 
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor
     * Inject the DI container
     * 
     * @param ContainerInterface $container 
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * Create a handler wrapper for the given handler
     * 
     * @param HandlerInterface $handler
     * @return HandlerWrapper 
     */
    public function createHandler(Handler $handler) 
    {
        return new HandlerWrapper($handler, $this->container);
    }
}
