<?php

namespace FrontBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $personHandler = $this->get('person_handler');

        if($personHandler->process())
        {
            return $this->redirect($this->generateUrl('front_homepage'));
        }

        $person = $personHandler->getAll();

        return $this->render('FrontBundle:Default:index.html.twig', array('person' => $person, 'form' => $personHandler->getForm()->createView()));
    }



    public function supprimerAction($id)
    {
        $supprimer = $this->get('person_handler');

        $supprimer->remove($id);

        return $this->redirect($this->generateUrl('front_homepage'));
    }
}
