<?php

namespace App\Security;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginFormAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface {

    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    public const HOME_ROUTE = 'homepage';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;
    private $container;
    private $security;

    /**
     * 
     * @param EntityManagerInterface $entityManager
     * @param UrlGeneratorInterface $urlGenerator
     * @param CsrfTokenManagerInterface $csrfTokenManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ContainerInterface $container
     * @param AuthorizationCheckerInterface $security
     */
    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder, ContainerInterface $container, AuthorizationCheckerInterface $security) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->container = $container;
        $this->security = $security;
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function supports(Request $request) {
        return in_array($request->attributes->get('_route'), [self::LOGIN_ROUTE, self::HOME_ROUTE]) && $request->isMethod('POST');
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function getCredentials(Request $request) {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
                Security::LAST_USERNAME,
                $credentials['email']
        );

        return $credentials;
    }

    /**
     * 
     * @param type $credentials
     * @param UserProviderInterface $userProvider
     * @return type
     * @throws InvalidCsrfTokenException
     * @throws CustomUserMessageAuthenticationException
     */
    public function getUser($credentials, UserProviderInterface $userProvider) {

        $token = new CsrfToken('authenticate', $credentials['csrf_token']);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(Usuario::class)->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Email could not be found.');
        }

        if ($user && !$user->getHabilitado()) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Your account is disabled.');
        }

        return $user;
    }

    /**
     * 
     * @param type $credentials
     * @param UserInterface $user
     * @return type
     */
    public function checkCredentials($credentials, UserInterface $user) {
      return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * 
     * @param type $credentials
     * @return string|null
     */
    public function getPassword($credentials): ?string {
        return $credentials['password'];
    }

    /**
     * 
     * @param Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     * @return RedirectResponse
     */
    public function onAuthenticationFailure(Request $request, \Symfony\Component\Security\Core\Exception\AuthenticationException $exception): RedirectResponse {

        $em = $this->entityManager;
        
        $email = $request->request->get('email');

        $user = $em->getRepository('App:Usuario')->findOneByEmail($email);

        if ($user) {

            // Incremento en 1 la cantidad de intentos fallidos
            $user->setLoginAttempts($user->getLoginAttempts() + 1);

            // Si la cantidad de intentos fallidos es igual a 3 intentos
            if ($user->getLoginAttempts() == 3) {

                // Deshabilito el usuario
                $user->setHabilitado(false);

                $request->getSession()->getFlashBag()->add('error', 'Su cuenta ha sido bloqueada luego de varios intentos fallidos de inicio de sesión. Puede recuperar su contraseña para continuar.');
            }
            // Si la cantidad de intentos fallidos es mayor a 3 intentos
            elseif ($user->getLoginAttempts() > 3) {
                $request->getSession()->getFlashBag()->add('error', 'Su cuenta se encuentra bloqueada por haber superado la cantidad máxima de intentos fallidos de inicio de sesión. Puede recuperar su contraseña para continuar.');
            }

            $em->flush();
        }

        return parent::onAuthenticationFailure($request, $exception);
    }

    /**
     * 
     * @param Request $request
     * @param TokenInterface $token
     * @param type $providerKey
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey) {

        $em = $this->entityManager;

        // Inicializo la cantidad de loginAttempts
        $token->getUser()->setLoginAttempts(0);
        $em->flush();

        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
        //throw new \Exception('TODO: provide a valid redirect inside ' . __FILE__);

        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('usuario_index'));
    }

    /**
     * 
     * @return type
     */
    protected function getLoginUrl() {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

}
