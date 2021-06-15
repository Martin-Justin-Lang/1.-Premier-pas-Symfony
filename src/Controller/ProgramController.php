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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Service\Slugify;


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
    public function new(Request $request,Slugify $slugifyService, MailerInterface $mailer) : Response
    {

        // Create a new program Object
        $program = new Program();
        // Create the associated Form
        $form = $this->createForm(ProgramType::class, $program);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()&& $form->isValid()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $slug = $slugifyService->generate($program->getTitle());
            $program->setSlug($slug);
            
            $entityManager = $this->getDoctrine()->getManager();
            // Persist program Object
            $entityManager->persist($program);
            // Flush the persisted object
            $entityManager->flush();

            $email = (new Email())
            ->from('your_email@example.com')
            ->to('your_email@example.com')
            ->subject('Une nouvelle série vient d\'être publiée !')
            ->html('<p>Une nouvelle série vient d\'être publiée sur Wild Séries !</p>');

            $mailer->send($email);
            $this->getParameter('mailer_from');


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
     * @Route("/show/{slug}", methods={"GET"}, name="show")
    */
    public function show(Program $program) : Response
    {

        return $this->render('program/show.html.twig', [
            'program' => $program
        ]);
    }


 /**
     * @Route("/{slug}/season/{season_slug}", name="season_show")
     * @ParamConverter("season", options={"mapping": {"season_slug": "slug"}})
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
     * @Route("/{slug}/seasons/{season_slug}/episodes/{episode_slug}", name="episode_show")
     * @ParamConverter("season", options={"mapping": {"season_slug": "slug"}})
     * @ParamConverter("episode", options={"mapping": {"episode_slug": "slug"}})
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