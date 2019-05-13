<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_index")
     */
    public function index()
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if(!$articles) {
            throw $this->createNotFoundException(
                'No article found in articl\'s table'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles]
        );
    }

    /**
     * @Route("/blog/show/{slug}",
     *          methods={"GET"},
     *          requirements={"slug"="[a-z0-9\-]+"},
     *          defaults={"slug"="article-sans-titre"},
     *          name="blog_show")
     */
    public function show(string $slug)
    {
            $cleanSlug = ucwords(trim(str_replace('-',' ',$slug)));
            return $this->render('Blog/show.html.twig', ['slug' => $cleanSlug]);
    }
}
