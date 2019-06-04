<?php

namespace App\Controller;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class CategoryController
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $repository;

    public function __construct(CategoryRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * @Route("/category", name="category_admin_index")
     */
    public function index()
    {
        $categories = $this->repository->findAll();

        return $this->render('admin_category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
        ]);
    }

    /**
     *
     * @Route("/category/add", name="category_admin_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request)
    {

        $session = new Session();

        $categories = $this->repository->findAll();

        $form = $this->createForm(CategoryType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            $session->getFlashBag()->add(
                'success',
                'Catégorie ajoutée avec succès'
            );

            return $this->redirectToRoute('category_admin_add');
        }

        return $this->render('admin_category/add.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories,
            'form' => $form->createView(),
        ]);

    }
}
