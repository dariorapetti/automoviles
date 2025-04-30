var vehiculoFormValidator = null;
jQuery(document).ready(function () {
  vehiculoFormValidator = FormValidation.formValidation($("form[name=vehiculo]")[0], {
    fields: {
      "vehiculo[marca]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[modelo]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[dominio]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[tipo]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[numeroMotor]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[numeroChasis]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[cotizacionDolar]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[precioCompraPesos]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[precioVentaPesos]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[precioCompraUsd]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
      "vehiculo[precioVentaUsd]": {
        validators: {
          notEmpty: {
            message: "Este campo es requerido",
          },
        },
      },
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap: new FormValidation.plugins.Bootstrap(),
      submitButton: new FormValidation.plugins.SubmitButton(),
      defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
    },
  });
  
  initDolarChange();
});

function initDolarChange(){
  $("#vehiculo_cotizacionDolar, #vehiculo_precioCompraPesos, #vehiculo_precioVentaPesos, #vehiculo_precioCompraUsd, #vehiculo_precioVentaUsd").on("change", function () {
    let cotizacion = AutoNumeric.getAutoNumericElement("#vehiculo_cotizacionDolar").getNumericString();
    if (cotizacion != "") {
      if($(this).attr('id') == "vehiculo_precioCompraPesos"){
        let precioCompraPesos = AutoNumeric.getAutoNumericElement("#vehiculo_precioCompraPesos").getNumericString();
        AutoNumeric.getAutoNumericElement("#vehiculo_precioCompraUsd").set(precioCompraPesos / cotizacion);
      }
      if ($(this).attr('id') == "vehiculo_precioVentaPesos") {
        let precioVentaPesos = AutoNumeric.getAutoNumericElement("#vehiculo_precioVentaPesos").getNumericString();
        AutoNumeric.getAutoNumericElement("#vehiculo_precioVentaUsd").set(precioVentaPesos / cotizacion);
      }
    }
  });
}