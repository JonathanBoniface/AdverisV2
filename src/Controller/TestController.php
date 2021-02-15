<?php

namespace App\Controller;



use App\Entity\Projects;
use App\Entity\PropertySearch;
use App\Form\ProjectType;
use App\Form\PropertySearchType;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ProjectsRepository
     */
    private $repository;

    public function __construct(ProjectsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/recherche", name="recherche")
     */
    public function index(Request $request): Response
    {
        $propertySearch = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$propertySearch);
        $form->handleRequest($request);
        //initialement le tableau des articles est vide,
        //c.a.d on affiche les articles que lorsque l'utilisateur clique sur le bouton rechercher
        $project = [];

        if($form->isSubmitted() && $form->isValid()) {
            //on récupère le nom d'article tapé dans le formulaire
            $name = $propertySearch->getName();
            if ($name!="")
                //si on a fourni un nom d'article on affiche tous les articles ayant ce nom
                $project= $this->getDoctrine()->getRepository(Projects::class)->findBy(['name' => $name] );
            else
                //si si aucun nom n'est fourni on affiche tous les articles
                $project= $this->getDoctrine()->getRepository(Projects::class)->findAll();
        }
        return  $this->render('test/index.html.twig',[
            'form' =>$form->createView(),
            'project' => $project]);
    }
}