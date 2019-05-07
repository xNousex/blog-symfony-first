<?php
// src/Controller/BlogController.php
namespace App\Controller;


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
        return new Response(
            '<html><body>Blog Index</body></html>'
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

            return $this->render('Blog/show.html.twig', ['slug' => $slug]);
    }
}
