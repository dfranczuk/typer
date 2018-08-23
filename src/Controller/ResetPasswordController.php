<?php
/**
 * Created by PhpStorm.
 * User: Radzio
 * Date: 17.08.2018
 * Time: 08:52
 */

namespace App\Controller;


use App\Form\ResetPasswordType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ResetPasswordController
 * @package App\Controller
 * @author Radoslaw Albiniak <radoslaw.albiniak@gmail.com>
 */
class ResetPasswordController extends AbstractController
{
    /**
     * @Route("/resetpass", name="reset_pass", methods="GET|POST")
     */
    public function reset(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $zapytanie = $form->get("field_email")->getData();


            $zapytanie1 = $form->get("field_username")->getData();
            /*  $zapytanie1arr=["username" => $zapytanie1, "email" => $zapytanie];
  */

            $user1 = $this->getDoctrine()->getRepository(User::class);
            $numberofusers = $user1->createQueryBuilder('u')
                ->select('u.username,  u.email')
                ->getQuery();
            $numberofusers = $numberofusers->execute();


            foreach ($numberofusers as $x) {

                if ($zapytanie == $x['email'] && $zapytanie1 == $x['username']) {

                    $email = $x['email'];
                    $username = $x['username'];
                    return $this->redirectToRoute('change_pass', ['email' => $email, 'username' => $username]);
                }

            }


            return $this->redirectToRoute('user_registration');
        }

        return $this->render('registration/resetpass.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}