$(function () {

    var start = moment();
    var end = moment();

    function cb(start, end) {
        $('#rangoDate').val('Del ' + start.format('DD/MM/YYYY') + ' al ' + end.format('DD/MM/YYYY'));
        $('#resultStart').val(start.format('YYYY-MM-DD'));
        $('#resultEnd').val(end.format('YYYY-MM-DD'));

        
        
    }

    $('#rangoDeFechas').daterangepicker({
        startDate: start,
        endDate: end,
        locale: {
            format: 'DD/MM/YYYY',
            applyLabel: 'Aplicar',
            cancelLabel:'Cancelar',
            fromLabel: 'from',
            toLabel: 'to',
            customRangeLabel: 'Personalizado',
            weekLabel: 'S',
            daysOfWeek: [
                'Do',
                'Lu',
                'Ma',
                'Mi',
                'Ju',
                'Vi',
                'Sa'
            ],
            monthNames: [
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ],
        },
        ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Esta semana': [moment().startOf('week'), moment().endOf('week')],
            'La semana anterior': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'El mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);


});