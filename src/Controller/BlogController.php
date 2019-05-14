<?php
// src/Controller/BlogController.php
namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    const limitResults = 3;

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
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $cleanSlug = ucwords(trim(str_replace('-',' ',$slug)));

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($cleanSlug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$cleanSlug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $cleanSlug,
            ]
        );
    }

/*    /**
     * @Route("/blog/category/{categoryName}",
     *          methods={"GET"},
     *          name="show_category")
     */
 /*   public function showByCategory(string $categoryName) : Response
    {

        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No category\'s name has been sent to find articles in article\'s table.');
        }

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneByName($categoryName);

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findByCategory($category,['id' => 'DESC'],self::limitResults);

        return $this->render(
            'blog/category.html.twig',
            [
                'articles' => $articles,
                'category' => $category,
            ]
        );

    }*/

    /**
     * @Route("/blog/category/{categoryName}",
     *          methods={"GET"},
     *          name="show_category")
     */
     public function showByCategory(string $categoryName) : Response
       {

           if (!$categoryName) {
               throw $this
                   ->createNotFoundException('No category\'s name has been sent to find articles in article\'s table.');
           }

           $category = $this->getDoctrine()
               ->getRepository(Category::class)
               ->findOneByName($categoryName);

           $articles = $category->getArticles();

           return $this->render(
               'blog/category.html.twig',
               [
                   'articles' => $articles,
                   'category' => $category,
               ]
           );

       }
}
