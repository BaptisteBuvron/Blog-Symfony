<?php

namespace App\Service;

use App\Entity\Customisation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

class CreatorDefaultValue
{

    private EntityManagerInterface $em;
    private KernelInterface $kernel;

    public function __construct(EntityManagerInterface $em, KernelInterface $kernel)
    {
        $this->em = $em;
        $this->kernel = $kernel;

    }

    /**
     * create a default customisation active if no active customisation exist
     */
    public function createDefaultCustomisationIfNotExist(): void
    {
        $customisationRepo = $this->em->getRepository(Customisation::class);
        $customisation = $customisationRepo->findOneBy(['isActive' => true]);
        if (is_null($customisation)){
            $dir = $this->kernel->getProjectDir();
            $fileSystem = new Filesystem();
            $fileSystem->copy($dir . '/public/images/default.png', $dir . '/public/images/custom/default.png');
            $fileSystem->copy($dir . '/public/images/defaultLogo.png', $dir . '/public/images/logo/defaultLogo.png');
            $customisation = new Customisation();
            $customisation->setTitle('Default title');
            $customisation->setDescription('Default description');
            $customisation->setLittleDescription('Default little description');
            $customisation->setIsActive(true);
            $customisation->setLogoFile(new UploadedFile($dir.'/public/images/logo/defaultLogo.png', 'defaultLogo.png', null, null, true));
            $customisation->setImageFile(new UploadedFile($dir.'/public/images/custom/default.png', 'default.png', null, null, true));
            $customisation->setInsta('https://www.instagram.com/');
            $customisation->setFacebook('https://www.facebook.com/');
            $customisation->setEmail("email@email.fr");
            $this->em->persist($customisation);
            $this->em->flush();
        }


    }

}