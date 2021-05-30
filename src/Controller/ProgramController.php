<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;


Class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     * 
     * @Route("/programs", name="program_index")
     * @return Response A reponse instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()->getRepository(Program::class)->findAll();

        return $this->render(
             'program/index.html.twig',
             ['programs' => $programs]
         );
    }
    /**
     * Getting a program by id
     * 
     * @return Response
     * @Route("/show/{id<^[0-9]+$>}", name="program_show")
    */
    public function show(int $id) : Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $id]);

        $season = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findBy(['program'=>$id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $season
        ]);
    }


/**
     * Getting a program by id
     * 
     * @return Response
     * @Route("/programs/{programId}/seasons/{seasonId}", name="program_season_show")
    */
public function showSeasons(int $programId, int $seasonId) : Response
    {
        $program = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findOneBy(['id' => $programId]);

        $season = $this->getDoctrine()
        ->getRepository(Season::class)
        ->findOneBy(['id' => $seasonId]);

        $episodes = $this->getDoctrine()
        ->getRepository(Episode::class)
        ->findBy(['season_id' => $seasonId]);

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'seasons' => $season,
            'episodes' => $episodes,
        ]);
    }

}