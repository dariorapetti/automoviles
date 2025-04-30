
jQuery(document).ready(function () {

  FormValidation.formValidation(
    $("form[name=cliente]")[0],
    {
      fields: {
        'cliente[nombre]': {
          validators: {
            notEmpty: {
              message: 'Este campo es requerido'
            }
          }
        },
        'cliente[direccion]': {
          validators: {
            notEmpty: {
              message: 'Este campo es requerido'
            }
          }
        },
        'cliente[telefono]': {
          validators: {
            notEmpty: {
              message: 'Este campo es requerido'
            }
          }
        },
        'cliente[email]': {
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