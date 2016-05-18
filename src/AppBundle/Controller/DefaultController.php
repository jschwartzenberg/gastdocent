<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Event;
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
    public function newAction()
    {
        $event = new Event();
        $event->setDate(new \DateTime());
        $event->setNumber(200);
        $event->setStatus(0);
        $event->setDescription('Another event!');

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($event);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();


//        return $this->render(
//            'new.html.twig'
//        );
        return $this->showAllAction();
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
