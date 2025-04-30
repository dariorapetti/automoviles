jQuery(document).ready(function () {
  vehiculoFormValidator.addField("vehiculo[proveedor]", {
    validators: {
        notEmpty: {
            message: "Este campo es requerido",
        },
    },
  });
});
