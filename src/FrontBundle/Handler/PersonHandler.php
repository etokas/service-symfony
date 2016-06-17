<?php

namespace FrontBundle\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class PersonHandler
{
    protected $form;
    protected $request;
    protected $em;


    public function __construct(Form $form, Request $request, EntityManager $em)
    {
        $this->form = $form;
        $this->request = $request;
        $this->em =  $em;
    }

    public function process()
    {
        $this->form->handleRequest($this->request);

        if($this->form->isValid() && $this->request->isMethod('post')){
            $this->onSucess();
            return true;
        }

        return false;

    }

    public function getAll()
    {
        return $this->em->getRepository('FrontBundle:Person')->findAll();
    }

    public function remove($id)
    {
        $repository = $this->em->getRepository('FrontBundle:Person');
        $person = $repository->find($id);
        $this->em->remove($person);
        $this->em->flush();
    }

    public function getForm()
    {
        return $this->form;
    }

    public function onSucess()
    {
        $this->em->persist($this->form->getData());
        $this->em->flush();

    }
}