<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();


        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{slug}-{id}", name="article.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Article $article
     * @return Response
     */
    public function post(Article $article, String $slug): Response
    {
        if ($article->getSlug() !== $slug){

            return $this->redirectToRoute('article.show',[
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ],301);
        }

        return $this->render('blog/post.html.twig',[
            'article' => $article
        ]);
    }
}
