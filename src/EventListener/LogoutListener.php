<?php

namespace App\EventListener;

use App\Entity\Constants\ConstanteAccionHistoricoEspecificacionesTecnicas;
use App\Entity\EspecificacionesTecnicas\InteresadoHistorico;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
 
class LogoutListener implements LogoutHandlerInterface
{

    private $entityManager;
    private $security;
    
    public function __construct(EntityManagerInterface $entityManager, Security $security) {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }


    /**
     * @{inheritDoc}
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $user = $token->getUser();

        if ($this->security->isGranted('ROLE_INTERESADO_ET')) {

            $interesadoHistorico = new InteresadoHistorico();

            $em = $this->entityManager;

            $interesadoRepository = $em->getRepository('App:EspecificacionesTecnicas\Interesado');
            $interesado = $interesadoRepository->createQueryBuilder('i')
                    ->leftJoin('i.usuario', 'u')
                    ->where('u.id = :idUsuario')
                    ->setParameter('idUsuario', $user->getId())
                    ->getQuery()
                    ->getOneOrNullResult();
        
            $interesadoHistorico->setInteresado($interesado);
            $interesadoHistorico->setFecha(new DateTime());
            $interesadoHistorico->setAccion(ConstanteAccionHistoricoEspecificacionesTecnicas::LOGOUT);

            $em->persist($interesadoHistorico);
            $em->flush();

        }
    }
}




