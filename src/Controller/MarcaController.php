<?php


namespace App\Controller;

use App\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/marca")
 */
class MarcaController extends BaseController
{
    /**
     * @Route("/", name="marca_index", methods={"GET"})
     * @Template("Marca/index.html.twig")
     * @IsGranted("ROLE_MARCA_VIEW")
     */
    public function index(): Array
    {
      return parent::baseIndexAction();
    }
    
    /**
     * Tabla para app_marca.
     *
     * @Route("/index_table/", name="marca_table", methods={"GET|POST"})
     * @IsGranted("ROLE_MARCA_VIEW")
     */
    public function indexTableAction(Request $request): Response 
    {
      $columnDefinition = [
        ['field' => 'id', 'type' => '', 'searchable' => false, 'sortable' => false],            
        ['field' => 'nombre', 'type' => 'string', 'searchable' => true, 'sortable' => true],
        ['field' => 'acciones', 'type' => '', 'searchable' => false, 'sortable' => false]
      ];

      return parent::baseIndexTableAction($request, $columnDefinition);
    }


    /**
     * @Route("/new", name="marca_new", methods={"GET","POST"})
     * @Template("Marca/new.html.twig")
     * @IsGranted("ROLE_MARCA_CREATE")
     */
    public function new(): Array
    {
      return parent::baseNewAction();        
    }

    /**
    * @Route("/insertar", name="marca_create", methods={"GET","POST"})
    * @Template("Marca/new.html.twig")
    * @IsGranted("ROLE_MARCA_CREATE")
    */
    public function createAction(Request $request)
    {
      return parent::baseCreateAction($request);
    }

    /**
     * @Route("/{id}", name="marca_show", methods={"GET"})
     * @Template("Marca/show.html.twig")
     * @IsGranted("ROLE_MARCA_VIEW")
     */
    public function show($id): Array
    {
      return parent::baseShowAction($id);
    }

    /**
    * @Route("/{id}/edit", name="marca_edit", methods={"GET","POST"})
    * @Template("Marca/new.html.twig")
    * @IsGranted("ROLE_MARCA_EDIT")
    */
    public function edit($id): Array
    {
      return parent::baseEditAction($id);
    }

    /**
    * @Route("/{id}/actualizar", name="marca_update", methods={"PUT"})
    * @Template("Marca/new.html.twig")
    * @IsGranted("ROLE_MARCA_EDIT")
    */
    public function update(Request $request, $id)
    {
      return parent::baseUpdateAction($request, $id);
    }

    /**
    * @Route("/{id}/borrar", name="marca_delete", methods={"GET"})
    * @IsGranted("ROLE_MARCA_DELETE")
    */
    public function delete($id)
    {
      return parent::baseDeleteAction($id);
    }
}
