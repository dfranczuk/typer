<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @Route("/user")

 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index", methods="GET")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('user/index.html.twig', ['users' => $users]);
    }


    /**
     * @Route("/{id}", name="user_show", methods="GET")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }



    /**
     * @param Request $request
     * @param User $user
     * @return Response
     * @author Radoslaw Albiniak <radoslaw.albiniak@gmail.com>
     */
    /**
     * @Route("/{email}/{username}/edit", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($file = $user->getBrochure() != NULL) {


                // $file stores the uploaded PDF file
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $user->getBrochure();

                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

                // moves the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('brochures_directory'),
                    $fileName);
                $user->setBrochure($fileName);
                $user->setBrochure($this->getParameter('brochures_directory') . '/' . $user->getBrochure());
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('user_edit', ['email' => $user->getEmail(), 'username' => $user->getUsername()]);
            }
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
