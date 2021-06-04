<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProgramType;
use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;


/**
* @Route("/programs", name="program_")
 */
Class ProgramController extends AbstractController
{
    /**
     * Show all rows from Program's entity
     * 
     * @Route("/", name="index")
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
     * The controller for the program add form
     * Display the form or deal with it
     *
     * @Route("/newprogram", name="newprogram")
     */
    public function new(Request $request) : Response
    {
        // Create a new program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist program Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('program_index');
        }
        // Render the form
        return $this->render('program/newprogram.html.twig', ["form" => $form->createView()]);
    }

    /**
     * Getting a program by id
     * 
     * @return Response
     * @Route("/show/{id}", requirements={"id"="\d+"}, methods={"GET"}, name="show")
    */
    public function show(Program $program) : Response
    {

        return $this->render('program/show.html.twig', [
            'program' => $program
        ]);
    }


 /**
     * @Route("/{program}/season/{season}", name="season_show")
     */
    public function showSeason(Program $program, Season $season): Response
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $season->getEpisode()
            ]);
    }

    /**
     * @Route("/{program}/seasons/{season}/episodes/{episode}", name="episode_show")
     */
    public function showEpisode(Program $program, Season $season, Episode $episode): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episode' => $episode
            ]);

}
}