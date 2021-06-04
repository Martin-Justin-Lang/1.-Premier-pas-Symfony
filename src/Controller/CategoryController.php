<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;
use App\Entity\Category;
use App\Entity\Program;


class CategoryController extends AbstractController
{

    /**
     * @Route("/categories", name="category_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $category = $this->getDoctrine()
             ->getRepository(Category::class)
             ->findAll();

         return $this->render(
             'category/index.html.twig',
             ['categories' => $category]
         );
    }

    /**
     * The controller for the category add form
     * Display the form or deal with it
     *
     * @Route("/new", name="new")
     */
    public function new(Request $request) : Response
    {
        // Create a new Category Object
        $category = new Category();
        // Create the associated Form
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        // Render the form
        return $this->render('category/new.html.twig', ["form" => $form->createView()]);
    }

    /**
     * @param int $id
     * @return Response
    * @Route("/categories/{id}", requirements={"id"="\d+"}, methods={"GET"}, name="category_name")
    */
    public function show(int $id) : Response
    {
        $category = $this->getDoctrine()->getRepository(Category::class)->findOneBy(['id' => $id]);

        if(!$category){
            throw $this->createNotFoundException(
                "No program with id : " .$category->getName(). "found in category's table." 
            );
        }
        
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $category], ['id' => 'DESC'],6);

        return $this->render('category/show.html.twig', ['category' => $category, 'programs' => $programs,]);
    }
    
}