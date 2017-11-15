<?php
namespace AppBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    protected $router;
    protected $token;

    public function __construct(RouterInterface $router, TokenStorageInterface $token)
    {
        $this->router = $router;
        $this->token = $token;
    }

    public function onLogoutSuccess(Request $request)
    {
        return new RedirectResponse($this->router->generate('homepage', ['logout' => 'success', 'username' => $this->token->getToken()->getUser()->getUsername()]));
    }
}
