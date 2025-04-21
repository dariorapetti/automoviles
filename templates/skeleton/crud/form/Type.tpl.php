<?= "<?php\n" ?>

<?php $excludedVariables = ['id', 'fechaCreacion', 'fechaUltimaModificacion', 'fechaBaja', 'usuarioCreacion', 'usuarioUltimaModificacion', 'codigoInterno'] ?>
<?php $typesLoaded = [] ?>
namespace <?= $namespace ?>;

<?php if ($bounded_full_class_name): ?>
use <?= $bounded_full_class_name ?>;
<?php endif ?>
use Symfony\Component\Form\AbstractType;
<?php foreach ($field_type_use_statements as $className): ?>
use <?= $className ?>;
<?php endforeach; ?>
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
<?php foreach ($constraint_use_statements as $className): ?>
use <?= $className ?>;
<?php endforeach; ?>

<?php foreach ($fields as $form_field => $typeOptions): ?>
    <?php if (!in_array($form_field, $excludedVariables)): ?>
        <?php if ($typeOptions['type'] == 'string' && !in_array($typeOptions['type'], $typesLoaded)): ?>
            <?php $typesLoaded[] = $typeOptions['type'];?>
use Symfony\Component\Form\Extension\Core\Type\TextType; 
        <?php endif; ?>
        <?php if ($typeOptions['type'] == 'date' && !in_array($typeOptions['type'], $typesLoaded)): ?>
            <?php $typesLoaded[] = $typeOptions['type'];?>
use Symfony\Component\Form\Extension\Core\Type\DateType;
        <?php endif; ?>
        <?php if ($typeOptions['type'] == 'choice' && !in_array($typeOptions['type'], $typesLoaded)): ?>
            <?php $typesLoaded[] = $typeOptions['type'];?>
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>

<?php if (!empty($association_fields)): ?>
    <?php if (!in_array('entity', $typesLoaded)): ?>
        <?php $typesLoaded[] = 'entity';?>
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
    <?php endif; ?>
    <?php foreach ($association_fields as $associationField): ?>
        <?php if (!in_array($associationField['fieldName'], $excludedVariables)): ?>
use <?= $associationField['targetEntity']; ?>;
        <?php endif; ?>
    <?php endforeach; ?>

<?php endif; ?>

class <?= $class_name ?> extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       

        $builder
        <?php foreach ($fields as $form_field => $typeOptions): ?>
            <?php if (!in_array($form_field, $excludedVariables)): ?>

                <?php $type = null === $typeOptions['type'] || $typeOptions['type'] == 'decimal' ? 'null' : $typeOptions['type']; ?>

                <?php switch($type){
                    case 'string': $clase = 'TextType::class';break;
                    case 'date': $clase = 'DateType::class';break;
                    default: $clase = '';
                }
                ?>

                ->add('<?= $form_field ?>', <?= $clase ?>, array(
                    <?php if($type == 'date'): ?>
                        'widget' => 'single_text',
                        'format' => 'dd/MM/yyyy',
                        'years' => range(Date('Y'), 2030),
                        'model_timezone' => 'America/Argentina/Buenos_Aires',
                    <?php endif; ?>
                    'required' => <?= isset($typeOptions['nullable']) && $typeOptions['nullable'] ? 'false' : 'true'?>,
                    'label' => '<?= ucfirst($form_field); ?>',
                    'attr' => array(
                    'class' => 'form-control<?= $type == 'date' ? ' datepicker' : '';?>',
                    'tabindex' => '5'))
                    )
            <?php endif; ?>
        <?php endforeach; ?>
        ;

        <?php if (!empty($association_fields)): ?>
            /* ASSOCIATION MAPPINGS */
            $builder
            <?php foreach ($association_fields as $associationField): ?>
                <?php if (!in_array($associationField['fieldName'], $excludedVariables)): ?>

                    <?php $clase = 'EntityType::class'; ?>

                    ->add('<?= $associationField['fieldName'] ?>', <?= $clase ?>, array(
                        'class' => <?= basename($associationField['targetEntity']) ?>::class,
                        'required' => <?= $associationField['required'] ? 'true' : 'false'?>,
                        'label' => '<?= ucfirst($associationField['fieldName']); ?>',
                        'placeholder' => '-- Elija <?= $associationField['fieldName']; ?> --',
                        'attr' => array(
                            'placeholder' => 'Escriba el <?= $associationField['fieldName']; ?> aquí.',
                            'class' => 'form-control choice',
                            'data-placeholder' => '-- Elija <?= $associationField['fieldName']; ?> --',
                            'tabindex' => '5')
                        )
                    )
                <?php endif; ?>
            <?php endforeach; ?>
            ;
        <?php endif; ?>

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
<?php if ($bounded_full_class_name): ?>
            'data_class' => <?= $bounded_class_name ?>::class,
<?php else: ?>
            // Configure your form options here
<?php endif ?>
        ]);
    }
}
