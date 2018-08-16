<?php

namespace App\Controller;

use App\Entity\ExpectedResults;
use App\Entity\Game;
use App\Form\ExpectedResults10Type;
use App\Repository\ExpectedResultsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/expected/results")
 */
class ExpectedResultsController extends Controller
{
    /**
     * @Route("/", name="expected_results_index", methods="GET")
     */
    public function index(ExpectedResultsRepository $expectedResultsRepository): Response
    {

        $repository1=$this->getDoctrine()->getRepository(ExpectedResults::class);
        $repository2=$this->getDoctrine()->getRepository(Game::class);
        $numberofmatch = $repository1->createQueryBuilder('u') // aktualnie to ilosc obstawionych meczy,
        ->select('u.id')
            ->getQuery();

       foreach($numberofmatch as $x){

             $query = $repository1->createQueryBuilder('p') //userID
 ->select("p.user_id_id")
 ->andWhere('p.id =: id')//gdzie idtypu=id przegladanego w petli
 ->setParameter('id',$x)
 ->getQuery();



             /*$query2 = $repository1->createQueryBuilder('a') //game_date_id
                ->select("a.game_date_id")
                ->andWhere('a.id =: id')//gdzie idtypu=id przegladanego w petli
                ->setParameter('id',$x)
                ->getQuery();

            $query3 = $repository2->createQueryBuilder('a')
                ->select("a.tournament_id")
                ->andWhere('a.id =: id')//gdzie idtypu=id przegladanego w petli
                ->setParameter('id',$query2)
                ->getQuery();

*/


        }






        return $this->render('expected_results/index.html.twig', ['expected_results' => $expectedResultsRepository->findAll()]);
    }

    /**
     * @Route("/new", name="expected_results_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $expectedResult = new ExpectedResults();
        $expectedResult1=new Game();
        $form = $this->createForm(ExpectedResults10Type::class, $expectedResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $repository1=$this->getDoctrine()->getRepository(Game::class);

            $meeting=$expectedResult->getNameOfMeeting();


            $expectedResult->setDateOfType(\DateTime::createFromFormat( 'Y-m-d H-i-s' ,date('Y-m-d H-i-s')));
            $em = $this->getDoctrine()->getManager();

            $em->persist($expectedResult);
            $em->flush();
            $EntityManager=$this->getDoctrine()->getManager();



            $expectedResult->setUserId($this->getUser());
         //   dump($expectedResult->getNameOfMeeting()->getGameDate());die;
    $expectedResult1->setGameDate($expectedResult->getNameOfMeeting()->getGameDate());
   // dump($expectedResult1->getGameDate());die;
            $expectedResult->setGameDateId($expectedResult1->getGameDate());

            $EntityManager->persist($expectedResult);
            $EntityManager->flush();
            return $this->redirectToRoute('expected_results_index');
        }

        return $this->render('expected_results/new.html.twig', [
            'expected_result' => $expectedResult,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expected_results_show", methods="GET")
     */
    public function show(ExpectedResults $expectedResult): Response
    {




        return $this->render('expected_results/show.html.twig', ['expected_result' => $expectedResult]);
    }

    /**
     * @Route("/{id}/edit", name="expected_results_edit", methods="GET|POST")
     */
    public function edit(Request $request, ExpectedResults $expectedResult): Response
    {
        $form = $this->createForm(ExpectedResults10Type::class, $expectedResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $expectedResult->setDateOfType(\DateTime::createFromFormat( 'Y-m-d H-i-s' ,date('Y-m-d H-i-s')));
            $this->getDoctrine()->getManager();

            $this->persist($expectedResult);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('expected_results_edit', ['id' => $expectedResult->getId()]);
        }

        return $this->render('expected_results/edit.html.twig', [
            'expected_result' => $expectedResult,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="expected_results_delete", methods="DELETE")
     */
    public function delete(Request $request, ExpectedResults $expectedResult): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expectedResult->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($expectedResult);
            $em->flush();
        }

        return $this->redirectToRoute('expected_results_index');
    }

}
