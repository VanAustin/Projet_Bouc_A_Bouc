<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface
{
    use TargetPathTrait;
    private $router;
    private $session;

    public function __construct(RouterInterface $router, SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $this->session->getFlashBag()->add('success', 'Merci pour votre inscription ' . $user = $event->getForm()->getData() . ', enjoy :)');
        $url = $this->getTargetPath($event->getRequest()->getSession(), 'main');
        if (!$url) {
            $url = $this->router->generate('homepage');
        }
        $response = new RedirectResponse($url);
        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        ];
    }
}
