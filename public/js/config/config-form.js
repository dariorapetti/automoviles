// CONFIG filestyle
if (typeof $().filestyle !== "undefined") {
  $.fn.filestyle.defaults = {
    text: "Examinar",
    htmlIcon: "",
    btnClass: "btn-secondary",
    size: "nr",
    input: true,
    badge: false,
    badgeName: "badge-light",
    buttonBefore: false,
    dragdrop: true,
    disabled: false,
    placeholder: "",
    onChange: function () {},
  };
}

jQuery(document).ready(function () {
  //Borrar action de las tablas
  initSelects();

  initChecksYRadios();

  initDatepickers();

  initForm();

  initPdfOptions();

  initCurrencies();
});

/**
 *
 * @returns {undefined}
 */
function initSelects() {
  if (typeof $().select2 !== "undefined") {
    $.fn.select2.defaults.set("language", "es");

    // Init select con la clase "choice"
    $("select.choice").each(function () {
      if (!$("#s2id_" + $(this).attr("id")).length) {
        var select2_options = {
          allowClear: typeof $(this).data("not-allow-clear") == "undefined",
          dropdownAutoWidth: true,
          theme: "default",
        };

        var parent = $(this).closest(".modal");

        if (parent.length) {
          select2_options.dropdownParent = parent;
        }

        $(this).select2(select2_options);

        if ($(this).attr("multiple")) {
          if (!$(this).hasClass("hide-select-all")) {
            var optionAll = new Option("-- Seleccionar todos --", "all");
            var optionClear = new Option("-- Limpiar selección --", "clear");

            $(this).prepend(optionClear);
            $(this).prepend(optionAll);
          }

          $(this).select2({
            escapeMarkup: function (m) {
              return m;
            },
            templateResult: function (object, container, query) {
              if (object.id == "all" || object.id == "clear")
                return (
                  '<span class="toggle-highlight" style="color:#31708F;font-size:13px;font-weight:bold;"> ' +
                  object.text +
                  "</span>"
                );
              return object.text;
            },
          });

          $(this).on("change", function (e) {
            if ($.inArray("all", $(this).val()) !== -1) {
              var selected = [];
              $(this)
                .find("option")
                .each(function (i, e) {
                  if (
                    $(e).attr("value") == "all" ||
                    $(e).attr("value") == "clear"
                  )
                    return true;

                  selected[selected.length] = $(e).attr("value");
                });
              $(this).val(selected).trigger("change");
            } else if ($.inArray("clear", $(this).val()) !== -1) {
              $(this).val(null).trigger("change");
            }
          });
        }

        // Select2 Opening Callback
        $(this).on("select2-opening", function () {
          closeActiveSelect2();
        });
      }
    });
  }
}

/**
 *
 * @returns {undefined}
 */
function closeActiveSelect2() {
  $(".select2-drop-active").hide();
  $(".select2-container-active.select2-dropdown-open").removeClass(
    "select2-dropdown-open"
  );
  $(".select2-container-active").removeClass(
    "select2-dropdown-open, select2-container-active"
  );
}

/**
 *
 * @param {type} element
 * @returns {undefined}
 */
function initDatepickers(element) {
  element = element === undefined ? document : element;

  $(element)
    .find("input.datepicker")
    .each(function () {
      //$(this).attr('readonly', 'readonly');
      // if (!$(this).parent().parent().hasClass('input-group')) {
      //     $(this).parent().wrap('<div class="input-group"></div>');
      //     $('<span class="input-group-addon"><i class="fa fa-calendar"></i></span>')
      //             .insertBefore($(this).parent());
      // }
    });

  $(".datepicker").each(function () {
    initDatepicker($(this));
  });

  // MONTH YEAR
  $(".monthyearpicker").each(function () {
    if (!$(this).is("[readonly]")) {
      initDatepicker($(this), {
        todayBtn: false,
        clearBtn: true,
        format: "mm-yyyy",
        viewMode: "months",
        minViewMode: 1,
        maxViewMode: 2,
      });
    }
  });

  // MONTH
  $(".monthpicker").each(function () {
    initDatepicker($(this), {
      todayBtn: false,
      clearBtn: false,
      format: "MM",
      viewMode: "months",
      minViewMode: 1,
      maxViewMode: 1,
    });
    if ($(this).val() !== "") {
      $(this).datepicker("show").datepicker("hide");
    }
    $(this).on("show", function (e) {
      $(".datepicker-dropdown .datepicker-months table thead tr th.prev").html(
        ""
      );
      $(
        ".datepicker-dropdown .datepicker-months table thead tr th.prev"
      ).removeClass("prev");
      $(
        ".datepicker-dropdown .datepicker-months table thead tr th.datepicker-switch"
      ).css("width", "145px");
      $(
        ".datepicker-dropdown .datepicker-months table thead tr th.datepicker-switch"
      ).removeClass("datepicker-switch");
      $(".datepicker-dropdown .datepicker-months table thead tr th.next").html(
        ""
      );
      $(
        ".datepicker-dropdown .datepicker-months table thead tr th.next"
      ).removeClass("next");
    });
  });

  // YEAR
  $(".yearpicker").each(function () {
    initDatepicker($(this), {
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
    });

    if (typeof Inputmask !== "undefined") {
      if (!$(this).hasClass("nomask")) {
        $(this).inputmask("9999");
      }
    }
  });
}

/**
 *
 * @param {type} element
 * @param {type} options
 * @returns {undefined}
 */
function initDatepicker(element, options) {
  if (options === undefined) {
    options = {};
  }

  var def_opts = {
    format: "dd/mm/yyyy",
    language: "es",
    autoclose: true,
  };

  $.extend(def_opts, options);

  $(element).datepicker(def_opts);

  if (!$(element).hasClass("novalidate")) {
    $(element).addClass("fecha_custom");
  }

  // if ((typeof Inputmask !== 'undefined' || $.inputmask) && !$(element).hasClass('nomask')) {
  //     $(element).inputmask('date', {placeholder: "_", yearrange: {minyear: 1900, maxyear: 2200}});
  // }
}

/**
 *
 * @returns {undefined}
 */
function initFileInputStyle() {
  if (typeof $().filestyle !== "undefined") {
    $(".filestyle").each(function () {
      $(this).filestyle({ text: "Examinar" });
      var $nombreArchivo = $(this).attr("data-file");
      if ($nombreArchivo) {
        $(this).next(".bootstrap-filestyle").find("input").val($nombreArchivo);
      }
    });
  }
}

/**
 *
 * @returns {undefined}
 */
function initChecksYRadios() {
  var swts = $("form input[type=checkbox]").not(
    ".not-checkbox-transform, [baseClass=bootstrap-switch]"
  );

  if (swts.length == 0) {
    return;
  }

  swts
    .attr({
      "data-on-text": "Si",
      "data-off-text": "No",
      "data-on-color": "success",
      "data-off-color": "default",
      baseClass: "bootstrap-switch",
    })
    .bootstrapSwitch();
}

/**
 *
 * @returns {undefined}
 */
function initForm() {
  $("form.horizontal-form").attr("autocomplete", "off");
}

/**
 *
 * @param {type} target
 * @returns {undefined}
 */
function hackSameHeight(target) {
  $(target).each(function () {
    $(this).css("min-height", "0px");
  });
  var maxHeight = 0;
  $(target).each(function () {
    if ($(this)[0].offsetHeight > maxHeight) {
      maxHeight = $(this)[0].offsetHeight;
    }
  });
  $(target).each(function () {
    $(this).css("min-height", maxHeight + "px");
  });
}

/**
 *
 * @returns {undefined}
 */
function initPdfOptions() {
  $(".row-pdf-show-custom").each(function () {
    hackSameHeight($(this).find(".option-pdf-target .box-pdf-file-show"));
  });

  $(document).on("click", ".option-pdf", function () {
    $(this).parents(".btn-group").find(".option-pdf").removeClass("blue");
    $(this).parents(".image-container").find(".label-option-pdf").html("Ver");
    $(this).addClass("blue");
    $(this).find(".label-option-pdf").html("Viendo");
    $(this)
      .parents(".image-container")
      .find(".option-pdf-target")
      .removeClass("col-md-3 col-md-4 col-md-6");
    $(this)
      .parents(".image-container")
      .find(".option-pdf-target")
      .addClass("col-md-" + Math.floor(12 / $(this).data("width")));
    $(this)
      .parents(".image-container")
      .find(".pdf-container-adjuntos")
      .css("height", $(this).data("width") == 2 ? "400px" : "300px");
    hackSameHeight(
      $(this)
        .parents(".row-pdf-show-custom")
        .find(".option-pdf-target .box-pdf-file-show")
    );
  });
}

/**
 *
 * @returns {undefined}
 */
function initCurrencies() {
  $(".currency, .percentage, .number, .numberPositive, .integerPositive").each(
    function () {
      $(this)
        .off("paste keypress")
        .bind("paste keypress", function (e) {
          // '46' = keyCode de '.'
          if (e.keyCode === 46 || e.charCode === 46) {
            e.preventDefault();

            $(this).val($(this).val() + ",");
          }
        });
    }
  );
  $(".currency").each(function () {
    var digits = 2;

    if (typeof $(this).data("digits") !== "undefined") {
      digits = $(this).data("digits");
    }

    $(this).val($(this).val().replace(/\./g, ","));

    // agregar separador de miles
    $(this).inputmask("decimal", { radixPoint: ",", digits: digits, thousandsSeparator: "." });
  });

  $(".percentage").each(function () {
    $(this).val($(this).val().replace(/\./g, ","));
    $(this).inputmask("Regex", {
      regex: "^100$|^[0-9]{1,2}$|^[0-9]{1,2},[0-9]{1,5}$",
    });
  });

  $(".number").each(function () {
    var digits = 2;

    if (typeof $(this).data("digits") !== "undefined") {
      digits = $(this).data("digits");
    }

    $(this).inputmask("decimal", {
      allowMinus: false,
      allowPlus: false,
      digits: digits,
    });
  });

  $(".numberPositive").each(function () {
    var digits = 2;

    if (typeof $(this).data("digits") !== "undefined") {
      digits = $(this).data("digits");
    }

    $(this).val($(this).val().replace(/\./g, ","));

    $(this).inputmask("decimal", {
      radixPoint: ",",
      allowMinus: false,
      allowPlus: false,
      digits: digits,
    });
  });

  $(".integerPositive").each(function () {
    $(this).inputmask("integer", { allowMinus: false, allowPlus: false });
  });
  
  // $('.currency-format').each(function () {
  //   $(this).autoNumeric('init', {vMin: '0.00', vMax: '9999999999.99',mDec: 2, aSep: '.', aDec: ',', currencySymbol: '$'});
  // });
  $('.currency-format').each(function () {
    new AutoNumeric($(this)[0], { 
      minimumValue: '0.00', 
      maximumValue: '9999999999.99',
      decimalCharacter: ',',
      decimalPlaces: 2,
      digitGroupSeparator: '.',
      currencySymbol: '$ '
    });
  });

  $('.currency-format-usd').each(function () {
    new AutoNumeric($(this)[0], { 
      minimumValue: '0.00', 
      maximumValue: '9999999999.99',
      decimalCharacter: ',',
      decimalPlaces: 2,
      digitGroupSeparator: '.',
      currencySymbol: 'U$S '
    });
  });
  
  // $('.currency-format-usd').each(function () {
  //   new AutoNumeric($(this)[0], { 
  //     vMin: '0.00', 
  //     vMax: '9999999999.99',
  //     mDec: 2, 
  //     aSep: '.', 
  //     aDec: ',', 
  //     currencySymbol: 'U$S '
  //   });
  // });
}
