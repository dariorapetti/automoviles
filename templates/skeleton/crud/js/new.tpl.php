<?php $excludedVariables = ['id', 'fechaCreacion', 'fechaUltimaModificacion', 'fechaBaja', 'usuarioCreacion', 'usuarioUltimaModificacion', 'codigoInterno'] ?>

jQuery(document).ready(function () {

   FormValidation.formValidation(
       $("form[name=<?= $entity_twig_var_singular ?>]")[0],
       {
           fields: {
               <?php foreach ($entity_fields as $field): ?>
                   <?php if (!in_array($field['fieldName'], $excludedVariables)): ?>
                       <?php if (isset($field['nullable']) && !$field['nullable']): ?>
                           '<?= $entity_twig_var_singular ?>[<?= $field['fieldName'] ?>]': {
                               validators: {
                                   notEmpty: {
                                       message: 'Este campo es requerido'
                                   }
                               }
                           },
                       <?php endif; ?>
                   <?php endif; ?>
               <?php endforeach; ?>
           },
           plugins: {
               trigger: new FormValidation.plugins.Trigger(),
               bootstrap: new FormValidation.plugins.Bootstrap(),
               submitButton: new FormValidation.plugins.SubmitButton(),
               defaultSubmit: new FormValidation.plugins.DefaultSubmit(),          
           }
       }
   );  
});