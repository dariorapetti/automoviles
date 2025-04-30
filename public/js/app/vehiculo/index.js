var app_vehiculo_table = null;

jQuery(document).ready(function () {
  app_vehiculo_table = $("#table-vehiculo");
  dataTablesInit(app_vehiculo_table, {
    ajax: __HOMEPAGE_PATH__ + "vehiculo/index_table/",
    columnDefs: datatablesGetColDef(),
    order: [[1, "asc"]],
  });
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
      name: "id",
      width: "30px",
      className: "dt-center",
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
      name: "tipo_vehiculo",
    },
    {
      targets: index++,
      name: "marca",
    },
    {
      targets: index++,
      name: "modelo",
    },
    {
      targets: index++,
      name: "dominio",
    },
    {
      targets: index++,
      name: "cotizacion_dolar",
    },
    {
      targets: index++,
      name: "precio_compra_usd",
    },
    {
      targets: index++,
      name: "precio_venta_usd",
    },
    {
      targets: index++,
      name: "precio_compra_pesos",
    },
    {
      targets: index++,
      name: "precio_venta_pesos",
    },
    {
      targets: -1,
      name: "acciones",
      title: "Acciones",
      orderable: false,
      render: dataTablesActionFormatter,
    },
  ];
}
