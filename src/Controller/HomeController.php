<?php

namespace App\Controller;



use App\Entity\Projects;
use App\Form\ProjectType;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ProjectsRepository
     */
    private $repository;

    public  function __construct (ProjectsRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $projects =   $this->repository->findAll();
        return $this->render('home/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/project/{id}", name="project")
     */
    public function details (Projects $project ): Response
    {
        return $this->render('home/details.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/projet/add", name="add_project")
     * @Route("/project/edit/{id}", name="project_modif")
     */
    public function edit (Projects $project = null, Request $request): Response
    {

        if(!$project){
            $project = new Projects();
        }

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $this->em->persist($project);
            $this->em->flush();
            return $this->redirectToRoute('home');
        }


        return $this->render('home/modifProject.html.twig', [
            'project' => $project,
            'form' => $form->createView()
        ]);
    }


}
