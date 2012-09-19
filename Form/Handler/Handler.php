<?php

namespace Aygon\FormHandlerBundle\Form\Handler;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Arno Geurts 
 */
abstract class Handler
{    
    /**
     * Build the form 
     * 
     * @param FormFactoryInteface $factory
     * @return Form
     */
    abstract public function createForm(FormFactoryInterface $factory);
    
    /**
     * Load data to the form
     * 
     * @param Form $form
     * @param mixed $data 
     * @return void
     */
    public function load($currentData, $newData) { }
    
    /**
     * Whether the form has been submitted
     * 
     * @param Request $request
     * @return boolean 
     */
    public function isSubmitted(Form $form, Request $request)
    {
        return $request->getMethod() == 'POST';
    }
    
    /**
     * Validate the form
     * 
     * @param Form $form
     * @param Request $request
     * @return boolean 
     */
    public function isValid(Form $form, Request $request)
    {
        if ( ! $form->isBound()) {
            $form->bindRequest($request);
        }
        return $form->isValid();
    }
    
    /**
     * Handle the submitted form
     * 
     * @param mixed $data
     * @param ContainerInterface $container 
     * @return boolean
     */
    abstract public function handle($data, ContainerInterface $container);
}
