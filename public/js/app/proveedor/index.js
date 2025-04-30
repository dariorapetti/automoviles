
var app_proveedor_table = null;

jQuery(document).ready(function () {

  app_proveedor_table = $('#table-proveedor');
  dataTablesInit(app_proveedor_table,
    {
      ajax: __HOMEPAGE_PATH__ + 'proveedor/index_table/',
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
    {
      targets: index++,
      name: 'razonSocial'
    },
    {
      targets: index++,
      name: 'direccion'
    },
    {
      targets: index++,
      name: 'telefonoOperador'
    },
    {
      targets: -1,
      name: 'acciones',
      title: 'Acciones',
      orderable: false,
      render: dataTablesActionFormatter
    }
  ];
}
