<?php

namespace App\EventSubscriber;

use App\Entity\Customisation;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }



    public static function getSubscribedEvents()
    {
        return [
            // the name of the event to listen to (the name of the method)
            AfterEntityUpdatedEvent::class => ['afterUpdate'],
            AfterEntityPersistedEvent::class => ['afterPersist']
        ];
    }


    public function afterPersist(AfterEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Customisation)) {
            return;
        }
        if ($entity->getIsActive()) {
            $this->disableActive($entity);
        }
    }

    public function afterUpdate(AfterEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Customisation)) {
            return;
        }
        if ($entity->getIsActive()) {
            //TODO disable all other customisations
            $this->disableActive($entity);
        }
    }

    /**
     * Disable all other customisations except the one passed
     * @param Customisation $customisation
     */
    public function disableActive(Customisation $customisation) : void
    {
        $customisationRepo = $this->em->getRepository(Customisation::class);

        $customisationValid = $customisationRepo->findBy(['isActive' => true]);
        dump($customisationValid);
        foreach ($customisationValid as $customisationOne) {
            if ($customisation->getId() !== $customisationOne->getId()) {
                $customisationOne->setIsActive(false);
            }
        }

        $this->em->flush();


    }


}
