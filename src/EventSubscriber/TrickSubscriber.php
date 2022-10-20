<?php

namespace App\EventSubscriber;

use App\Entity\Tricks;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class TrickSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->persistTrick($args);
        $this->saveTrick($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->saveTrick($args);
    }

    private function persistTrick(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof Tricks) {
            return;
        }

        $args->getObject()->setCreatedAt(new \DateTimeImmutable());
    }

    private function saveTrick(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if (!$entity instanceof Tricks) {
            return;
        }

        $entity->setUpdatedAt(new \DateTimeImmutable());
        $entity->setSlug($this->generateSlug($entity->getName()));
    }

    /**
     * Generate Slug
     * @param string $name
     * @return string
     */
    private function generateSlug(string $name): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    }
}
