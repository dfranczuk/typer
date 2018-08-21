<?php

namespace App\Controller;

use App\Entity\TypeOfEvent;
use App\Form\TypeOfEventType;
use App\Repository\TypeOfEventRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




/**
 * Class TypeOfEventController
 * @package App\Controller
 * @author Mateusz Poniatowski <mateusz@live.hk>
 */
/**
 * @Route("/type/of/event")
 * @Security("is_granted('ROLE_ADMIN')")
 */



class TypeOfEventController extends Controller
{
    /**
     * @Route("/", name="type_of_event_index", methods="GET")
     */
    public function index(TypeOfEventRepository $typeOfEventRepository): Response
    {
        return $this->render('type_of_event/index.html.twig', ['type_of_events' => $typeOfEventRepository->findAll()]);
    }

    /**
     * @Route("/new", name="type_of_event_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $typeOfEvent = new TypeOfEvent();
        $form = $this->createForm(TypeOfEventType::class, $typeOfEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeOfEvent);
            $em->flush();

            return $this->redirectToRoute('type_of_event_index');
        }

        return $this->render('type_of_event/new.html.twig', [
            'type_of_event' => $typeOfEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_of_event_show", methods="GET")
     */
    public function show(TypeOfEvent $typeOfEvent): Response
    {
        return $this->render('type_of_event/show.html.twig', ['type_of_event' => $typeOfEvent]);
    }

    /**
     * @Route("/{id}/edit", name="type_of_event_edit", methods="GET|POST")
     */
    public function edit(Request $request, TypeOfEvent $typeOfEvent): Response
    {
        $form = $this->createForm(TypeOfEventType::class, $typeOfEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_of_event_edit', ['id' => $typeOfEvent->getId()]);
        }

        return $this->render('type_of_event/edit.html.twig', [
            'type_of_event' => $typeOfEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_of_event_delete", methods="DELETE")
     */
    public function delete(Request $request, TypeOfEvent $typeOfEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeOfEvent->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeOfEvent);
            $em->flush();
        }

        return $this->redirectToRoute('type_of_event_index');
    }
}
