<?php

namespace App\EventListener;

use App\Security\InvalidCaptchaException;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class CaptchaListener implements EventSubscriberInterface
{
    private $recaptcha_web_key;
    private $recaptcha_secret_key;
    private $requestStack;
    private $container;

    public function __construct($recaptcha_web_key, $recaptcha_secret_key, RequestStack $requestStack, ContainerInterface $container)
    {
        $this->recaptcha_web_key = $recaptcha_web_key;
        $this->recaptcha_secret_key = $recaptcha_secret_key;
        $this->requestStack = $requestStack;
        $this->container = $container;
    }

    public function onKernelRequest(RequestEvent $event)
    {

        if (!$event->isMasterRequest()) {
            return;
        }

        if ($this->container->get('session')->get('captcha_validado') === null) {
            $request = $this->requestStack->getCurrentRequest();
            if (!empty($this->recaptcha_web_key)) {
                if ($event->getRequest()->getPathInfo() === '/login' && $request->request->get('email') !== null) {
                    $recaptchaToken = $request->request->get('g-recaptcha-response');
                    $action = $request->request->get('action');
                    if (!$this->validarRecaptcha($recaptchaToken, $action)) {
                        throw new InvalidCaptchaException();
                    }
                    $this->container->get('session')->set('captcha_validado', true);
                }
            } else {
                $this->container->get('session')->set('captcha_validado', true);
            }
        }
        return;
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'onKernelRequest'
        ];
    }

    /**
     * 
     * @param type $token
     * @param type $action
     * @return boolean
     */
    private function validarRecaptcha($token, $action)
    {

        $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptchaData = array(
            'secret' => $this->recaptcha_secret_key,
            'response' => $token
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($recaptchaData)
            )
        );

        $context = stream_context_create($options);
        $response = file_get_contents($recaptchaUrl, false, $context);

        /**
         * $responseKeys structure:
         * 
         * {
         *  "success": true|false,      // whether this request was a valid reCAPTCHA token for your site
         *  "challenge_ts": timestamp,  // timestamp of the challenge load (ISO format yyyy-MM-dd'T'HH:mm:ssZZ)
         *  "hostname": string,         // the hostname of the site where the reCAPTCHA was solved
         *  "error-codes": [...]        // optional
         * }
         */
        $responseKeys = json_decode($response, true);

        header('Content-type: application/json');

        return $responseKeys["success"];
    }
}
