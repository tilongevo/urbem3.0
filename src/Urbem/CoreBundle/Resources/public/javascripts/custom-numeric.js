$('.numeric').on('input', function (event) {
    this.value = this.value.replace(/[^0-9]/g, '');
});