$(function () {
    $('input[name="fecha"]').daterangepicker(
        {
            opens: 'left',
            "locale": {
                "format": "YYYY-MM-DD",
                "separator": " - ",
                "applyLabel": "Aplicar",
                "cancelLabel": "Cancelar",
                "fromLabel": "De",
                "toLabel": "a",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "do",
                    "lu",
                    "ma",
                    "mi",
                    "ju",
                    "vi",
                    "sá"
                ],
                "monthNames": [
                    "énero",
                    "febrero",
                    "marzo",
                    "abril",
                    "mayo",
                    "junio",
                    "julio",
                    "agusto",
                    "septiembre",
                    "octubre",
                    "noviembre",
                    "diciembre"
                ],
                "firstDay": 1
            }
        }
    );
});