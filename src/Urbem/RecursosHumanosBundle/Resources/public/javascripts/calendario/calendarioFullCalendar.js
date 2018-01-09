var calendario = function (calendarios) {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay',
            lang:'pt-br'
        },
        defaultDate: moment().format('YYYY-MM-DD'),
        editable: true,
        eventLimit: true,
        events: calendarios,
        eventRender: function(event, element) {
            element.find('.fc-title').append("<br/>" + event.titleTwo);
        }
    });
};