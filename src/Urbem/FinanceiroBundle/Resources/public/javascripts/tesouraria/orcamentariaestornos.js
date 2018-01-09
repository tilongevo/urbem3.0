var boletim = UrbemSonata.giveMeBackMyField('boletim'),
    data = UrbemSonata.giveMeBackMyField('data');

boletim.on('change', function () {
    data.val($('select#' + UrbemSonata.uniqId + '_boletim option:selected').text().substr(-10));
});