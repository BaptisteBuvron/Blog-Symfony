<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImageController extends AbstractController
{

    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/pictures/articles/{img}', name: 'picture_article')]
    /**
     * @IsGranted("ROLE_USER")
     */
    public function article(string $img): Response
    {
        $dir = $this->kernel->getProjectDir();
        $filepath = $dir . '/secure/pictures/articles/' . $img;

        if (file_exists($filepath)) {
            //return a new BinaryFileResponse with the file name
            return new BinaryFileResponse($filepath);
        }

        return new JsonResponse(null, 404);

    }

    #[Route('/pictures/galleries/{img}', name: 'picture_gallerie')]
    /**
     * @IsGranted("ROLE_USER")
     */
    public function galleries(string $img): Response
    {
        $dir = $this->kernel->getProjectDir();
        $filepath = $dir . '/secure/pictures/galleries/' . $img;

        if (file_exists($filepath)) {
            //return a new BinaryFileResponse with the file name
            return new BinaryFileResponse($filepath);
        }

        return new JsonResponse(null, 404);

    }





}
