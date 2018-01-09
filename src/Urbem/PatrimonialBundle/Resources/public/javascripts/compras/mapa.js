(function(){
    'use strict';

    var renderMinusIcon = function (targetId) {
        $('a[data-target="#' + targetId + '"]')
            .find('i.fa')
            .removeClass('fa-minus-square')
            .addClass('fa-plus-square');
    };

    $(document).on('hidden.bs.collapse', 'div[id^="accordion-local-"]', function (e) {
        var elementId = $(this).prop('id');

        if (!$('#' + elementId).is(':visible')) {
            renderMinusIcon(elementId);
        }
    });

    $(document).on('show.bs.collapse', 'div[id^="accordion-local-"]', function (e) {
        var element = $(this)
            , elementId = $(this).prop('id');

        if (element.html().length === 0) {
            $('a[data-target="#' + elementId + '"]').find('i.fa')
                .removeClass('fa-plus-square')
                .addClass('fa-minus-square');
        } else {
            // Muda icone de + para -
            $('a[data-target="#' + elementId + '"]').find('i.fa')
                .removeClass('fa-plus-square')
                .addClass('fa-minus-square');
        }
    });

}());
