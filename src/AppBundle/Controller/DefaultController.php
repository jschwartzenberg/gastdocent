<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
use AppBundle\Form\EventType;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/overview", name="overview")
     */
    public function showAllAction()
    {
        $events = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->findAll();

        return $this->render(
            'overview.html.twig',
            array('events' => $events)
        );
    }

    /**
     * @Route("/new", name="new")
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('overview');
        }


        return $this->render('new.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * @Route("/show/{eventId}", name="show")
     */
    public function showAction($eventId)
    {
        $event = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->find($eventId);

        if (!$event) {
            throw $this->createNotFoundException(
                'No event found for id '.$eventId
            );
        }

        return $this->render(
            'show.html.twig',
            array('event' => $event)
        );
    }

    /**
     * @Route("/delete/{eventId}", name="delete")
     */
    public function deleteAction($eventId)
    {
        $event = $this->getDoctrine()
            ->getRepository('AppBundle:Event')
            ->find($eventId);

        if (!$event) {
            throw $this->createNotFoundException(
                'No event found for id '.$eventId
            );
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return new Response('Deleted event.');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
}
