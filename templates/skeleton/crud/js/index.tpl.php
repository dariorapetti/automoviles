<?php $excludedVariables = ['id', 'fechaCreacion', 'fechaUltimaModificacion', 'fechaBaja', 'usuarioCreacion', 'usuarioUltimaModificacion', 'codigoInterno'] ?>

var <?= $route_name ?>_table = null;

jQuery(document).ready(function () {

    <?= $route_name ?>_table = $('#table-<?= $route_name ?>');
dataTablesInit(<?= $route_name ?>_table,
        {
            ajax: __HOMEPAGE_PATH__ + '<?= strtolower($entity_class_name) ?>/index_table/',
            columnDefs: datatablesGetColDef(),
            order: [[1, 'asc']]
        }
);    
});

/**
 * 
 * @returns {Array}
 */
function datatablesGetColDef() {

    let index = 0;

    return [
    {
        targets: index++,
        name: 'id',
        width: '30px',
        className: 'dt-center',
        orderable: false,
        render: function (data, type, full, meta) {
            return '\
                    <label class="kt-checkbox kt-checkbox--single kt-checkbox--solid">\
                        <input type="checkbox" value="" class="kt-checkable">\
                        <span></span>\
                    </label>';
        },
    },
    <?php foreach ($entity_fields as $field): ?>
        <?php if (!in_array($field['fieldName'], $excludedVariables)): ?>
        {
            targets: index++,
            name: '<?= $field['fieldName'] ?>'
        },
        <?php endif; ?>
    <?php endforeach; ?>
    {
        targets: -1,
        name: 'acciones',
        title: 'Acciones',
        orderable: false,
        render: dataTablesActionFormatter
    }
];
}
