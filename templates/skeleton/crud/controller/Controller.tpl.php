<?= "<?php\n" ?>

<?php $excludedVariables = ['id', 'fechaCreacion', 'fechaUltimaModificacion', 'fechaBaja', 'usuarioCreacion', 'usuarioUltimaModificacion', 'codigoInterno'] ?>

namespace <?= $namespace ?>;

use App\Controller\BaseController;
use <?= $entity_full_class_name ?>;
use <?= $form_full_class_name ?>;
<?php if (isset($repository_full_class_name)): ?>
use <?= $repository_full_class_name ?>;
<?php endif ?>
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/<?= strtolower($entity_class_name) ?>")
 */
class <?= $class_name ?> extends BaseController
{
    /**
     * @Route("/", name="<?= strtolower($entity_class_name) ?>_index", methods={"GET"})
     * @Template("<?= $templates_path ?>/index.html.twig")
     * @IsGranted("ROLE_<?= strtoupper($entity_twig_var_singular) ?>_VIEW")
     */
    public function index(): Array
    {
        return parent::baseIndexAction();
    }
    
    /**
     * Tabla para <?= $route_name ?>.
     *
     * @Route("/index_table/", name="<?= strtolower($entity_class_name) ?>_table", methods={"GET|POST"})
     * @IsGranted("ROLE_<?= strtoupper($entity_twig_var_singular) ?>_VIEW")
     */
    public function indexTableAction(Request $request): Response 
    {
        $columnDefinition = [
            ['field' => 'id', 'type' => '', 'searchable' => false, 'sortable' => false],            
            <?php foreach ($entity_fields as $form_field => $typeOptions): ?>
                <?php if (!in_array($form_field, $excludedVariables)): ?>
                    <?php switch($typeOptions['type']){
                        case 'integer': 
                        case 'float': 
                        case 'decimal': $clase = 'number';break;
                        case 'entity': 
                        case 'boolean': $clase = 'select';break;
                        case 'date': $clase = 'date';break;
                        case 'datetime': $clase = 'datetime';break;
                        default: $clase = 'string';
                    }
                    ?>
            ['field' => '<?= $form_field;?>', 'type' => '<?= $clase;?>', 'searchable' => true, 'sortable' => true],
                <?php endif; ?>
            <?php endforeach; ?>
            ['field' => 'acciones', 'type' => '', 'searchable' => false, 'sortable' => false]
        ];

        return parent::baseIndexTableAction($request, $columnDefinition);
    }


    /**
     * @Route("/new", name="<?= strtolower($entity_class_name) ?>_new", methods={"GET","POST"})
     * @Template("<?= $templates_path ?>/new.html.twig")
     * @IsGranted("ROLE_<?= strtoupper($entity_twig_var_singular) ?>_CREATE")
     */
    public function new(): Array
    {
        return parent::baseNewAction();        
    }

    /**
    * @Route("/insertar", name="<?= strtolower($entity_class_name) ?>_create", methods={"GET","POST"})
    * @Template("<?= $templates_path ?>/new.html.twig")
    * @IsGranted("ROLE_<?= strtoupper($entity_twig_var_singular) ?>_CREATE")
    */
    public function createAction(Request $request)
    {
        return parent::baseCreateAction($request);
    }

    /**
     * @Route("/{id}", name="<?= strtolower($entity_class_name) ?>_show", methods={"GET"})
     * @Template("<?= $templates_path ?>/show.html.twig")
     * @IsGranted("ROLE_<?= strtoupper($entity_twig_var_singular) ?>_VIEW")
     */
    public function show($id): Array
    {
        return parent::baseShowAction($id);
    }

    /**
    * @Route("/{id}/edit", name="<?= strtolower($entity_class_name) ?>_edit", methods={"GET","POST"})
    * @Template("<?= $templates_path ?>/new.html.twig")
    * @IsGranted("ROLE_<?= strtoupper($entity_twig_var_singular) ?>_EDIT")
    */
    public function edit($id): Array
    {
        return parent::baseEditAction($id);
    }

    /**
    * @Route("/{id}/actualizar", name="<?= strtolower($entity_class_name) ?>_update", methods={"PUT"})
    * @Template("<?= $templates_path ?>/new.html.twig")
    * @IsGranted("ROLE_<?= strtoupper($entity_twig_var_singular) ?>_EDIT")
    */
    public function update(Request $request, $id)
    {
        return parent::baseUpdateAction($request, $id);
    }

    /**
    * @Route("/{id}/borrar", name="<?= strtolower($entity_class_name) ?>_delete", methods={"GET"})
    * @IsGranted("ROLE_<?= strtoupper($entity_twig_var_singular) ?>_DELETE")
    */
    public function delete($id)
    {
        return parent::baseDeleteAction($id);
    }
}
