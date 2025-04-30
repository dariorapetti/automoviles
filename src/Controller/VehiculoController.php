<?php

namespace App\Controller;

use App\Entity\Vehiculo;
use App\Entity\VehiculoCero;
use App\Entity\VehiculoUsado;
use App\Form\VehiculoCeroType;
use App\Form\VehiculoUsadoType;
use App\Controller\BaseController;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Constants\ConstanteTipoConsulta;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/vehiculo")
 */
class VehiculoController extends BaseController
{
  /**
   * @Route("/", name="vehiculo_index", methods={"GET"})
   * @Template("Vehiculo/index.html.twig")
   * @IsGranted("ROLE_VEHICULO_VIEW")
   */
  public function index(): array
  {
    $extraParams = [
      'select_tipo_vehiculo' => $this->getSelectService()->getTipoVehiculoSelect()
    ];
    return parent::baseIndexAction($extraParams);
  }

  /**
   * Tabla para app_vehiculo.
   *
   * @Route("/index_table/", name="vehiculo_table", methods={"GET|POST"})
   * @IsGranted("ROLE_VEHICULO_VIEW")
   */
  public function indexTableAction(Request $request): Response
  {
    $entityTable = 'view_vehiculo';

    $rsm = new ResultSetMapping();

    $rsm->addScalarResult('id', 'id');
    $rsm->addScalarResult('tipo_vehiculo', 'tipo_vehiculo');
    $rsm->addScalarResult('cliente_proveedor', 'cliente_proveedor');
    $rsm->addScalarResult('marca', 'marca');
    $rsm->addScalarResult('modelo', 'modelo');
    $rsm->addScalarResult('dominio', 'dominio');
    $rsm->addScalarResult('cotizacion_dolar', 'cotizacion_dolar');
    $rsm->addScalarResult('precio_compra_usd', 'precio_compra_usd');
    $rsm->addScalarResult('precio_venta_usd', 'precio_venta_usd');
    $rsm->addScalarResult('precio_compra_pesos', 'precio_compra_pesos');
    $rsm->addScalarResult('precio_venta_pesos', 'precio_venta_pesos');

    $columnDefinition = [
      ['field' => 'id', 'type' => '', 'searchable' => false, 'sortable' => false],
      ['field' => 'tipo_vehiculo', 'type' => 'select', 'searchable' => false, 'sortable' => false],
      ['field' => 'cliente_proveedor', 'type' => '', 'searchable' => false, 'sortable' => false],
      ['field' => 'marca', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'modelo', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'dominio', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'cotizacion_dolar', 'type' => 'number', 'searchable' => true, 'sortable' => true],
      ['field' => 'precio_compra_usd', 'type' => 'number', 'searchable' => true, 'sortable' => true],
      ['field' => 'precio_venta_usd', 'type' => 'number', 'searchable' => true, 'sortable' => true],
      ['field' => 'precio_compra_pesos', 'type' => 'number', 'searchable' => true, 'sortable' => true],
      ['field' => 'precio_venta_pesos', 'type' => 'number', 'searchable' => true, 'sortable' => true],
      ['field' => 'acciones', 'type' => '', 'searchable' => false, 'sortable' => false],
    ];

    $renderPage = "vehiculo/index_table.html.twig";

    return parent::baseIndexTableAction($request, $columnDefinition, $entityTable, ConstanteTipoConsulta::VIEW, $rsm, $renderPage);
  }

  /**
   * @Route("/cero/new", name="vehiculo_cero_new", methods={"GET","POST"})
   * @Template("Vehiculo/new.cero.html.twig")
   * @IsGranted("ROLE_VEHICULO_CREATE")
   */
  public function newCero(): array
  {
    $entity = new VehiculoCero();
    $form = $this->baseCreateCreateFormCero($entity);
    $this->setNewFormValues($form, $entity);
    $breadcrumbs = $this->getNewBaseBreadcrumbs($form, $entity);
    $parametros = array(
      'entity' => $entity,
      'form' => $form->createView(),
      'form_action' => 'vehiculo_cero_create',
      'breadcrumbs' => $breadcrumbs,
      'page_title' => 'Agregar ' . $this->getEntityRenderName()
    );

    return array_merge($parametros, $this->getExtraParametersNewAction($entity));
  }

  /**
   * 
   * @param type $entity
   * @return FormInterface
   */
  protected function baseCreateCreateFormCero($entity): FormInterface
  {
    $form = $this->baseInitCreateCreateFormCero(VehiculoCeroType::class, $entity);

    $form->add('submit', SubmitType::class, array(
      'label' => 'Agregar',
      'attr' => array('class' => 'btn btn-light-primary font-weight-bold submit-button'))
    );

    return $form;
  }

  /**
   * 
   * @param string $entityFormTypeClassName
   * @param type $entity
   * @return FormInterface
   */
  protected function baseInitCreateCreateFormCero($entityFormTypeClassName, $entity): FormInterface
  {
    return $this->createForm($entityFormTypeClassName, $entity, array(
      'action' => $this->generateUrl('vehiculo_cero_create'),
      'method' => 'POST'
    ));
  }

  /**
   * @Route("/insertar", name="vehiculo_cero_create", methods={"GET","POST"})
   * @Template("Vehiculo/new.cero.html.twig")
   * @IsGranted("ROLE_VEHICULO_CREATE")
   */
  public function createCeroAction(Request $request)
  {
    $entity = new VehiculoCero();

    $form = $this->baseCreateCreateFormCero($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();

      if ($this->checkPersistEntityInCreateAction()) {
        $em->persist($entity);
      }

      $em->flush();

      $this->execPostPersistAction($entity, $request);

      $message = $this->getCreateMessage(true);
      
      $this->get('session')->getFlashBag()->add('success', $message);
      return $this->getCreateRedirectResponse($request, $entity);      
    } else {
      $request->attributes->set('form-error', true);
    }    
    $breadcrumbs = $this->getNewBaseBreadcrumbs($form, $entity);

    $parametros = array(
      'entity' => $entity,
      'form' => $form->createView(),
      'breadcrumbs' => $breadcrumbs,
      'page_title' => 'Agregar ' . $this->getEntityRenderName()
    );

    return array_merge($parametros, $this->getExtraParametersNewAction($entity));    
  }

  /**
   * @Route("/usado/new", name="vehiculo_usado_new", methods={"GET","POST"})
   * @Template("Vehiculo/new.usado.html.twig")
   * @IsGranted("ROLE_VEHICULO_CREATE")
   */
  public function newUsado(): array
  {
    $entity = new VehiculoUsado();
    $form = $this->baseCreateCreateFormUsado($entity);
    $this->setNewFormValues($form, $entity);
    $breadcrumbs = $this->getNewBaseBreadcrumbs($form, $entity);
    $parametros = array(
      'entity' => $entity,
      'form' => $form->createView(),
      'form_action' => 'vehiculo_usado_create',
      'breadcrumbs' => $breadcrumbs,
      'page_title' => 'Agregar ' . $this->getEntityRenderName()
    );

    return array_merge($parametros, $this->getExtraParametersNewAction($entity));
  }

  /**
   * 
   * @param type $entity
   * @return FormInterface
   */
  protected function baseCreateCreateFormUsado($entity): FormInterface
  {
    $form = $this->baseInitCreateCreateFormUsado(VehiculoUsadoType::class, $entity);

    $form->add('submit', SubmitType::class, array(
      'label' => 'Agregar',
      'attr' => array('class' => 'btn btn-light-primary font-weight-bold submit-button'))
    );

    return $form;
  }

  /**
   * 
   * @param string $entityFormTypeClassName
   * @param type $entity
   * @return FormInterface
   */
  protected function baseInitCreateCreateFormUsado($entityFormTypeClassName, $entity): FormInterface
  {
    return $this->createForm($entityFormTypeClassName, $entity, array(
      'action' => $this->generateUrl('vehiculo_usado_create'),
      'method' => 'POST'
    ));
  }

  /**
   * @Route("/insertar", name="vehiculo_usado_create", methods={"GET","POST"})
   * @Template("Vehiculo/new.usado.html.twig")
   * @IsGranted("ROLE_VEHICULO_CREATE")
   */
  public function createUsadoAction(Request $request)
  {
    $entity = new VehiculoUsado();

    $form = $this->baseCreateCreateFormUsado($entity);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();

      if ($this->checkPersistEntityInCreateAction()) {
        $em->persist($entity);
      }

      $em->flush();

      $this->execPostPersistAction($entity, $request);

      $message = $this->getCreateMessage(true);
      
      $this->get('session')->getFlashBag()->add('success', $message);
      return $this->getCreateRedirectResponse($request, $entity);      
    } else {
      $request->attributes->set('form-error', true);
    }    
    $breadcrumbs = $this->getNewBaseBreadcrumbs($form, $entity);

    $parametros = array(
      'entity' => $entity,
      'form' => $form->createView(),
      'breadcrumbs' => $breadcrumbs,
      'page_title' => 'Agregar ' . $this->getEntityRenderName()
    );

    return array_merge($parametros, $this->getExtraParametersNewAction($entity));    
  }

  /**
   * @Route("/{id}", name="vehiculo_show", methods={"GET"})
   * @Template("Vehiculo/show.html.twig")
   * @IsGranted("ROLE_VEHICULO_VIEW")
   */
  public function show($id): array
  {
    return parent::baseShowAction($id);
  }

  /**
   * @Route("/{id}/edit", name="vehiculo_edit", methods={"GET","POST"})
   * @Template("Vehiculo/new.html.twig")
   * @IsGranted("ROLE_VEHICULO_EDIT")
   */
  public function edit($id): array
  {
    return parent::baseEditAction($id);
  }

  /**
   * @Route("/{id}/actualizar", name="vehiculo_update", methods={"PUT"})
   * @Template("Vehiculo/new.html.twig")
   * @IsGranted("ROLE_VEHICULO_EDIT")
   */
  public function update(Request $request, $id)
  {
    return parent::baseUpdateAction($request, $id);
  }

  /**
   * @Route("/{id}/borrar", name="vehiculo_delete", methods={"GET"})
   * @IsGranted("ROLE_VEHICULO_DELETE")
   */
  public function delete($id)
  {
    return parent::baseDeleteAction($id);
  }
}
