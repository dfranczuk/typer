<?php

namespace App\Controller;

use App\Entity\ExpectedResults;
use App\Entity\Game;
use App\Entity\Scoreboard;
use App\Entity\User;
use App\Form\ScoreboardType;
use App\Repository\ScoreboardRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/scoreboard")
 */
class ScoreboardController extends Controller
{


    /**
     * @Route("/", name="scoreboard_index", methods="GET")
     */
    public function index(ScoreboardRepository $scoreboardRepository): Response

    {
        $entityManager = $this->getDoctrine()->getManager();
        $repo1 = $this->getDoctrine()->getRepository(Scoreboard::class);
        $repo2 = $this->getDoctrine()->getRepository(ExpectedResults::class);
        $repo3 = $this->getDoctrine()->getRepository(User::class);

        $cmd = $entityManager->getClassMetadata(Scoreboard::class);
        $connection = $entityManager->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($cmd->getTableName());
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');


        $userpoints = $repo2->createQueryBuilder('t')
            ->select('(t.user_id) as uid', 'sum(t.points) as suma')
            ->groupBy('t.user_id')
            ->orderBy('suma', 'DESC')
            ->getQuery();
        $userpoints = $userpoints->execute(); // wykonuje zapytanie i zwraca rekordy z id usera i punktami

        $username = $repo3->createQueryBuilder('m')
            ->select('m.id as muid', 'm.username as muname')
            ->getQuery();
        $username = $username->execute();
        
      //  dump($userpoints);die;
       // dump($username);die;

    //-------------------------------------------------

        $query = $this->createQueryBuilder('c')
            ->select('(c.name) as utourname')
            ->innerJoin('Scoreboard::class', 'co', 'WITH', 'co.id = c.id')
            ->innerJoin('Tournament::class', 'ct', 'WITH', 'ct.id = c.id')
            ->orderBy('c.createdAt', 'DESC')
            ->where('co.group = :group OR ct.group = :group')
            ->setParameter('group', $group)
            ->setMaxResults(20);









   //----------------------------------------------------------

        foreach ($userpoints as $key) {

            $points = $key['suma'];
            $userid = $key['uid'];
            $scoreboard = new Scoreboard();
            $scoreboard->setUsrid($userid);
            $scoreboard->setPoints($points);
            foreach ($username as $key2)
            {
                $usermuid = $key2['muid'];
                $usermuname = $key2['muname'];
                if($userid==$usermuid){
                   // dump("test");
                    $scoreboard->setUserName( $usermuname);
                }

            }
            // var_dump($);
            //  var_d/mp(" ");
            $entityManager->persist($scoreboard);
        }

        $entityManager->flush($scoreboard);
        $entityManager->refresh($scoreboard);

        return $this->render('scoreboard/index.html.twig', ['scoreboards' => $scoreboardRepository->findAll()]);
    }


    /*
        public function calculatePoints(?int $totalPoints) {


            $totalPoints = $totalPoints + $user_id->getPoint();
            $this->totalpoints = $totalPoints;

            return $this;
        }
    */

    /**
     * @Route("/new", name="scoreboard_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $scoreboard = new Scoreboard();
        $form = $this->createForm(ScoreboardType::class, $scoreboard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($scoreboard);
            $em->flush();

            return $this->redirectToRoute('scoreboard_index');
        }

        return $this->render('scoreboard/new.html.twig', [
            'scoreboard' => $scoreboard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scoreboard_show", methods="GET")
     */
    public function show(Scoreboard $scoreboard): Response
    {
        return $this->render('scoreboard/show.html.twig', ['scoreboard' => $scoreboard]);
    }

    /**
     * @Route("/{id}/edit", name="scoreboard_edit", methods="GET|POST")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function edit(Request $request, Scoreboard $scoreboard): Response
    {
        $form = $this->createForm(ScoreboardType::class, $scoreboard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scoreboard_edit', ['id' => $scoreboard->getId()]);
        }

        return $this->render('scoreboard/edit.html.twig', [
            'scoreboard' => $scoreboard,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="scoreboard_delete", methods="DELETE")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function delete(Request $request, Scoreboard $scoreboard): Response
    {
        if ($this->isCsrfTokenValid('delete' . $scoreboard->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($scoreboard);
            $em->flush();
        }

        return $this->redirectToRoute('scoreboard_index');
    }
}
