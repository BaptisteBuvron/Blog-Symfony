<?php

namespace App\Twig;

use App\Entity\Customisation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions(): array
    {

        return [
            new TwigFunction('get_customisation', [$this, 'getCustomisation']),
        ];
    }

    public function getCustomisation(): Customisation
    {
        $customisationRepo = $this->em->getRepository(Customisation::class);
        $customisation = $customisationRepo->findOneBy(['isActive' => true]);
        if (is_null($customisation)) {
            $dir = $this->containerBag->get('kernel.project_dir');
            $fileSystem = new Filesystem();
            $fileSystem->copy($dir . '\public\images\default.png', $dir . '\public\images\custom\default.png');
            $customisation = new Customisation();
            $customisation->setIsActive(true);
            $customisation->setImageFile(new UploadedFile($dir . "\public\images\custom\default.png", $dir . "\public\images\custom\default.png", null, null, true));
            $customisation->setImageName('default.png');
            $customisation->setTitle("Default Title");
            $customisation->setDescription("Default Description");
            $customisation->setEmail("email@email.fr");
            $customisation->setFacebook("https://www.facebook.com/");
            $customisation->setInsta("https://www.instagram.com/");
            $customisation->setLittleDescription("Little description");

            $this->em->persist($customisation);
            $this->em->flush();
        }
        return $customisation;
    }
}