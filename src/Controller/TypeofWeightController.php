<?php

namespace App\Controller;

use App\Entity\TypeofWeight;
use App\Form\TypeofWeightType;
use App\Repository\TypeofWeightRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/typeof/weight")
 * @Security("is_granted('ROLE_ADMIN')")
 */
class TypeofWeightController extends Controller
{
    /**
     * @Route("/", name="typeof_weight_index", methods="GET")
     */
    public function index(TypeofWeightRepository $typeofWeightRepository): Response
    {
        return $this->render('typeof_weight/index.html.twig', ['typeof_weights' => $typeofWeightRepository->findAll()]);
    }

    /**
     * @Route("/new", name="typeof_weight_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $typeofWeight = new TypeofWeight();
        $form = $this->createForm(TypeofWeightType::class, $typeofWeight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeofWeight);
            $em->flush();

            return $this->redirectToRoute('typeof_weight_index');
        }

        return $this->render('typeof_weight/new.html.twig', [
            'typeof_weight' => $typeofWeight,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typeof_weight_show", methods="GET")
     */
    public function show(TypeofWeight $typeofWeight): Response
    {
        return $this->render('typeof_weight/show.html.twig', ['typeof_weight' => $typeofWeight]);
    }

    /**
     * @Route("/{id}/edit", name="typeof_weight_edit", methods="GET|POST")
     */
    public function edit(Request $request, TypeofWeight $typeofWeight): Response
    {
        $form = $this->createForm(TypeofWeightType::class, $typeofWeight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeof_weight_index', ['id' => $typeofWeight->getId()]);
        }

        return $this->render('typeof_weight/edit.html.twig', [
            'typeof_weight' => $typeofWeight,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typeof_weight_delete", methods="DELETE")
     */
    public function delete(Request $request, TypeofWeight $typeofWeight): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeofWeight->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeofWeight);
            $em->flush();
        }

        return $this->redirectToRoute('typeof_weight_index');
    }
}
