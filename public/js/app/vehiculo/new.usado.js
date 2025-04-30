jQuery(document).ready(function () {
  vehiculoFormValidator.addField("vehiculo[cliente]", {
    validators: {
        notEmpty: {
            message: "Este campo es requerido",
        },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[anio]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[kilometros]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[kitSeguridad]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[cubreAlfombras]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[titulo]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[cedulaVerde]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[formulario08]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[grabadoAutopartes]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
  vehiculoFormValidator.addField("vehiculo_usado[duplicadoLlaves]", {
    validators: {
      notEmpty: {
        message: "Este campo es requerido",
      },
    },
  });
});
