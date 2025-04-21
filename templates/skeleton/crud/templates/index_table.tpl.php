<?php $excludedVariables = ['id', 'fechaCreacion', 'fechaUltimaModificacion', 'fechaBaja', 'usuarioCreacion', 'usuarioUltimaModificacion', 'codigoInterno'] ?>
{
"data": [
{% for entity in entities %}
    [
    "{{ entity.id }}",
    <?php foreach ($entity_fields as $form_field => $typeOptions): ?>
        <?php if (!in_array($form_field, $excludedVariables)): ?>
            <?php if (in_array($typeOptions['type'], ['date', 'datetime'])):?>
    "{{ entity.<?= str_replace('_', '', $form_field) ?> is not null ? entity.<?= str_replace('_', '', $form_field) ?>|date(\'d/m/Y <?= $typeOptions['type'] == 'datetime'? ' H:i:s' : '' ?> ') : '-' }}",
            <?php else: ?>
            <?php if ($typeOptions['type'] == 'boolean'):?>
    "{{ entity.<?= str_replace('_', '', $form_field) ?>|booleanFormat }}",
            <?php else: ?>
    "{{ entity.<?= str_replace('_', '', $form_field) ?>|default('-') }}",
            <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
    {
    "show" : " {{ path( "<?= $route_name ?>_show", { "id": entity.id }) }}"
    ,"edit" : " {{ path( "<?= $route_name ?>_edit", { "id": entity.id }) }}"
    ,"delete" : " {{ path( "<?= $route_name ?>_delete", { "id": entity.id }) }}"
    }
    ]{{ (loop.last ? '' : ',') }}
{% endfor %}
],
"draw": {{ draw }},
"recordsTotal": {{ totalRows }},
"recordsFiltered": {{ totalFiltered }}
}