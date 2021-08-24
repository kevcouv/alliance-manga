<?php

namespace App\Customers;

use App\Entity\Address;
use App\Entity\Comment;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;

class ProductCustomer implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.

        return [
            BeforeEntityPersistedEvent::class=>['setUser'],
        ];
    }


    public function setUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if ($entity instanceof Product || $entity instanceof Comment ||  $entity instanceof Address ){
        $entity->setUser($this->security->getUser());
        $this->security->getUser();
        }
    }


}