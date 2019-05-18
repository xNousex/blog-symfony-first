<?php

namespace App\Controller;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    /**
     * @var TagRepository
     */
    private $repository;

    public function __construct(TagRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * @Route("/tag", name="tag")
     */
    public function index()
    {
        $tags = $this->repository->findAll();
        return $this->render('tag/index.html.twig', [
            'controller_name' => 'TagController',
            'tags' => $tags,
        ]);
    }
}
