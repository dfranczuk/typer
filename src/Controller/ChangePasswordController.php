<?php
/**
 * Created by PhpStorm.
 * User: Radzio
 * Date: 14.08.2018
 * Time: 12:46
 */

namespace App\Controller;


    use App\Form\ChangePasswordType;
    use App\Entity\User;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Symfony\Component\HttpFoundation\Response;

class ChangePasswordController extends AbstractController
{

    /**
     * @author Radoslaw Albiniak    <radoslaw.albiniak@gmail.com>
     */

    /**
     * @Route("/user/{email}/{username}/changepass", name="change_pass", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('change_pass', ['id' => $user->getId()]);
        }

        return $this->render('registration/changepass.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

}