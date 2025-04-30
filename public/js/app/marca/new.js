
jQuery(document).ready(function () {

  FormValidation.formValidation(
    $("form[name=marca]")[0],
    {
      fields: {
        'marca[nombre]': {
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