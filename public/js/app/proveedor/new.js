
jQuery(document).ready(function () {
  FormValidation.formValidation(
    $("form[name=proveedor]")[0],
      {
        fields: {
          'proveedor[razonSocial]': {
            validators: {
              notEmpty: {
                message: 'Este campo es requerido'
              }
            }
          },
          'proveedor[direccion]': {
            validators: {
              notEmpty: {
                message: 'Este campo es requerido'
              }
            }
          },
          'proveedor[telefonoOperador]': {
            validators: {
              notEmpty: {
                message: 'Este campo es requerido'
              }
            }
          },
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