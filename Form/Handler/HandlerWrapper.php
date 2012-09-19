<?php

namespace Aygon\FormHandlerBundle\Form\Handler;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;

/**
 * @author Arno Geurts 
 */
class HandlerWrapper
{
    /**
     * The handler
     * @var HandlerInterface 
     */
    private $handler;
    
    /**
     * The DI container 
     * @var ContainerInterface
     */
    private $container;
    
    /**
     * The form 
     * @var Form 
     */
    private $form;
    
    /**
     * Constructor
     * Inject the DI container
     * 
     * @param ContainerInterface $container 
     */
    public function __construct(Handler $handler, ContainerInterface $container)
    {
        $this->handler = $handler;
        $this->container = $container;
    }
    
    /**
     * Create the form view
     * 
     * @return FormView
     */
    public function createFormView()
    {
        return $this->getForm()->createView();
    }
    
    /**
     * Load data to the form
     * 
     * @param mixed $data
     * @param boolean force
     * @return void
     */
    public function load($data)
    {
        $newData = $this->handler->load($this->getForm()->getData(), $data);
        
        // in case new data was returned, reload the data to the form
        if ($newData !== null) {
            $this->getForm()->setData($newData);
        }
    }
    
    /**
     * Handle the form
     * 
     * @return boolean 
     */
    public function handle()
    {
        if ( ! $this->isSubmitted() || ! $this->isValid()) {
            return false;
        }
        return $this->handler->handle($this->getForm()->getData(), $this->container);
    }
    
    /**
     * Whether the form is submitted
     * 
     * @return boolean 
     */
    public function isSubmitted()
    {
        return $this->handler->isSubmitted($this->getForm(), $this->container->get('request'));
    }
    
    /**
     * Whether the form is submitted
     * 
     * @return boolean 
     */
    public function isValid()
    {
        return $this->handler->isValid($this->getForm(), $this->container->get('request'));
    }
    
    /**
     * Get the form
     * 
     * @return Form 
     */
    protected function getForm()
    {
        if ($this->form === null) {
            $this->form = $this->handler->createForm($this->container->get('form.factory'));
        }
        return $this->form;
    }
}
