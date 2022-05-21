<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{

    /**
     * @Route("/comment/delete-{id}", name="comment.delete", methods={"DELETE"})
     * @param Comment $comment
     * @return Response
     * @IsGranted ("ROLE_USER")
     */
    public function delete(Comment $comment, EntityManagerInterface $manager, Request $request) {
        $csrfToken = $request->request->get('_token');
        $user = $this->getUser();
        if (($user === $comment->getAuthor() || $this->isGranted('ROLE_ADMIN')) && $this->isCsrfTokenValid('delete' . $comment->getId(), $csrfToken)) {
            $manager->remove($comment);
            $manager->flush();
            $this->addFlash('success', 'Votre commentaire a bien été supprimé');
        }
        else {
            $this->addFlash('danger', 'Vous n\'avez pas le droit de supprimer ce commentaire');
        }
        return $this->redirectToRoute('article.show', ['id' => $comment->getArticle()->getId(), 'slug' => $comment->getArticle()->getSlug()]);
    }



}