<?php


namespace App\Controller;

use App\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proveedor")
 */
class ProveedorController extends BaseController
{
  /**
   * @Route("/", name="proveedor_index", methods={"GET"})
   * @Template("Proveedor/index.html.twig")
   * @IsGranted("ROLE_PROVEEDOR_VIEW")
   */
  public function index(): Array
  {
    return parent::baseIndexAction();
  }
  
  /**
   * Tabla para app_proveedor.
   *
   * @Route("/index_table/", name="proveedor_table", methods={"GET|POST"})
   * @IsGranted("ROLE_PROVEEDOR_VIEW")
   */
  public function indexTableAction(Request $request): Response 
  {
    $columnDefinition = [
      ['field' => 'id', 'type' => '', 'searchable' => false, 'sortable' => false],            
      ['field' => 'razonSocial', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'direccion', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'telefonoOperador', 'type' => 'string', 'searchable' => true, 'sortable' => true],
      ['field' => 'acciones', 'type' => '', 'searchable' => false, 'sortable' => false]
    ];

    return parent::baseIndexTableAction($request, $columnDefinition);
  }


  /**
   * @Route("/new", name="proveedor_new", methods={"GET","POST"})
   * @Template("Proveedor/new.html.twig")
   * @IsGranted("ROLE_PROVEEDOR_CREATE")
   */
  public function new(): Array
  {
    return parent::baseNewAction();        
  }

  /**
  * @Route("/insertar", name="proveedor_create", methods={"GET","POST"})
  * @Template("Proveedor/new.html.twig")
  * @IsGranted("ROLE_PROVEEDOR_CREATE")
  */
  public function createAction(Request $request)
  {
    return parent::baseCreateAction($request);
  }

  /**
   * @Route("/{id}", name="proveedor_show", methods={"GET"})
   * @Template("Proveedor/show.html.twig")
   * @IsGranted("ROLE_PROVEEDOR_VIEW")
   */
  public function show($id): Array
  {
    return parent::baseShowAction($id);
  }

  /**
  * @Route("/{id}/edit", name="proveedor_edit", methods={"GET","POST"})
  * @Template("Proveedor/new.html.twig")
  * @IsGranted("ROLE_PROVEEDOR_EDIT")
  */
  public function edit($id): Array
  {
    return parent::baseEditAction($id);
  }

  /**
  * @Route("/{id}/actualizar", name="proveedor_update", methods={"PUT"})
  * @Template("Proveedor/new.html.twig")
  * @IsGranted("ROLE_PROVEEDOR_EDIT")
  */
  public function update(Request $request, $id)
  {
    return parent::baseUpdateAction($request, $id);
  }

  /**
  * @Route("/{id}/borrar", name="proveedor_delete", methods={"GET"})
  * @IsGranted("ROLE_PROVEEDOR_DELETE")
  */
  public function delete($id)
  {
    return parent::baseDeleteAction($id);
  }
  
  protected function getEntityPluralName() {
    return 'Proveedores';
  }
}
