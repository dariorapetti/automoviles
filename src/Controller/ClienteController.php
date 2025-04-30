<?php


namespace App\Controller;

use App\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cliente")
 */
class ClienteController extends BaseController
{
  /**
   * @Route("/", name="cliente_index", methods={"GET"})
   * @Template("Cliente/index.html.twig")
   * @IsGranted("ROLE_CLIENTE_VIEW")
   */
  public function index(): Array
  {
    return parent::baseIndexAction();
  }
  
  /**
   * Tabla para app_cliente.
   *
   * @Route("/index_table/", name="cliente_table", methods={"GET|POST"})
   * @IsGranted("ROLE_CLIENTE_VIEW")
   */
  public function indexTableAction(Request $request): Response 
  {
    $columnDefinition = [
      ['field' => 'id', 'type' => '', 'searchable' => false, 'sortable' => false],            
      ['field' => 'nombre', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'direccion', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'telefono', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'email', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'acciones', 'type' => '', 'searchable' => false, 'sortable' => false]
    ];

    return parent::baseIndexTableAction($request, $columnDefinition);
  }

  /**
   * @Route("/new", name="cliente_new", methods={"GET","POST"})
   * @Template("Cliente/new.html.twig")
   * @IsGranted("ROLE_CLIENTE_CREATE")
   */
  public function new(): Array
  {
    return parent::baseNewAction();        
  }

  /**
  * @Route("/insertar", name="cliente_create", methods={"GET","POST"})
  * @Template("Cliente/new.html.twig")
  * @IsGranted("ROLE_CLIENTE_CREATE")
  */
  public function createAction(Request $request)
  {
    return parent::baseCreateAction($request);
  }

  /**
   * @Route("/{id}", name="cliente_show", methods={"GET"})
   * @Template("Cliente/show.html.twig")
   * @IsGranted("ROLE_CLIENTE_VIEW")
   */
  public function show($id): Array
  {
    return parent::baseShowAction($id);
  }

  /**
  * @Route("/{id}/edit", name="cliente_edit", methods={"GET","POST"})
  * @Template("Cliente/new.html.twig")
  * @IsGranted("ROLE_CLIENTE_EDIT")
  */
  public function edit($id): Array
  {
    return parent::baseEditAction($id);
  }

  /**
  * @Route("/{id}/actualizar", name="cliente_update", methods={"PUT"})
  * @Template("Cliente/new.html.twig")
  * @IsGranted("ROLE_CLIENTE_EDIT")
  */
  public function update(Request $request, $id)
  {
    return parent::baseUpdateAction($request, $id);
  }

  /**
  * @Route("/{id}/borrar", name="cliente_delete", methods={"GET"})
  * @IsGranted("ROLE_CLIENTE_DELETE")
  */
  public function delete($id)
  {
    return parent::baseDeleteAction($id);
  }
}
