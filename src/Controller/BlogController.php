<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{




    /**
     * @Route("/", name="home")
     * @param ArticleRepository $articleRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     * @IsGranted ("ROLE_USER")
     */
    public function index(ArticleRepository $articleRepository, PaginatorInterface  $paginator, Request $request): Response
    {
        $articles = $paginator->paginate(
            $articleRepository->findAllVisibleQuery(),
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/{slug}-{id}", name="article.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Article $article
     * @return Response
     * @IsGranted ("ROLE_USER")
     */
    public function post(Article $article, String $slug, Request  $request, EntityManagerInterface $manager, PaginatorInterface $paginator, CommentRepository $commentRepository): Response
    {
        if ($article->getSlug() !== $slug){

            return $this->redirectToRoute('article.show',[
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ],301);
        }

        $comments = $paginator->paginate($article->getComments(),
            $request->query->getInt('page', 1),
            12
        );
        $comment = new Comment();

        $form = $this->createForm(CommentType::class,$comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $comment->setAuthor($user);
            $comment->setArticle($article);
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash('success','Votre commentaire a été publié.');
            return $this->redirect($request->getUri());
        }


        return $this->render('blog/post.html.twig',[
            'article' => $article,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/galerie/{slug}-{id}", name="galerie.show", requirements={"slug": "[a-z0-9\-]*"})
     * @IsGranted ("ROLE_USER")
     */
    public function gallery(Article $article, String $slug){
        if ($article->getSlug() !== $slug){

            return $this->redirectToRoute('galerie.show',[
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ],301);
        }
        if ($article->getGalleries()->isEmpty()){
            return $this->redirectToRoute('article.show',['id' => $article->getId(), 'slug' => $article->getSlug()],301);
        }

        return $this->render('blog/gallery.html.twig',[
            'article' => $article]
       );
    }
}
