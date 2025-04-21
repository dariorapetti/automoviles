<?php

namespace App\Controller;

use App\Entity\Constants\ConstanteEstadoDocumentoTecnico;
use App\Entity\Constants\ConstanteGrupo;
use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/public_access")
 */
class PublicAccessController extends AbstractController
{

    /**
     * @Route("/et_send_mail_trimestral/", name="public_access_et_send_mail_trimestral", methods={"GET"})
     */
    public function especificacionesTecnicasSendMailTrimestral(MailerInterface $mailer)
    {
        $diaActual = date('N');
        // N devuelve el numero del dia de la semana (1-7) empezando desde el lunes
        // Se debe ejecutar el primer miercoles del mes
        // En el cron se ejecuta del 1 al 7 los meses enero, abril, julio, octubre
        if ($diaActual == 3) {
            $em = $this->getDoctrine()->getManager();

            $adjuntoDocumentoTecnico = $em->getRepository('App:EspecificacionesTecnicas\AdjuntoDocumentoTecnico')
                ->createQueryBuilder('adt')
                ->innerJoin('adt.estado', 'e')
                ->where('e.codigoInterno = :estadoAprobado')
                ->setParameter('estadoAprobado', ConstanteEstadoDocumentoTecnico::PUBLICADO)
                ->getQuery()
                ->getResult();

            $adjuntos = [];

            foreach ($adjuntoDocumentoTecnico as $adjunto) {
                $fechaActual = new DateTime();
                $fechaActual = $fechaActual->modify('-3 month');
                if ($fechaActual->format('Ymd') * 1 < $adjunto->getFechaAprobacion()->format('Ymd') * 1) {
                    $adjuntos[] = $adjunto;
                }
            }

            $usuarios = $em->getRepository("App:Usuario")
                ->createQueryBuilder('u')
                ->select('u.id, u.email')
                ->innerJoin('u.grupos', 'g')
                ->where('g.codigoInterno = :codigoInteresado')
                ->andWhere('u.habilitado = 1')
                ->setParameter('codigoInteresado', ConstanteGrupo::INTERESADO_ESPECIFICACIONES_TECNICAS)
                ->getQuery()
                ->getArrayResult();

            $emails = array_column($usuarios, 'email');

            if (count($emails) > 0 && count($adjuntos) > 0) {
                $mailET = new Address($this->getParameter('dsn_info_especificaciones_tecnicas'), 'ADIFSE');
                $email = (new TemplatedEmail())
                    ->from($mailET)
                    ->to($mailET)
                    ->bcc(...$emails)
                    ->subject('Alerta bibliográfico de Especificaciones Técnicas ADIFSE')
                    ->htmlTemplate('especificacionestecnicas/adjuntodocumentotecnico/email_publicacion_trimestral.html.twig')
                    ->context([
                        'adjuntos' => $adjuntos
                    ]);

                $email->getHeaders()->addTextHeader('X-Transport', 'info_especificaciones_tecnicas');

                $mailer->send($email);
            }
        }

        die;
    }
}
