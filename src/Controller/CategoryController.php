<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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