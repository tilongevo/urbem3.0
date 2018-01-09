var link = document.getElementById('versao-btn'); // Assumes element with id='button'

$(window).click(function() {
    $('#versao-box').hide();
})
    .on('keyup', function (event) {
        if (event.keyCode == 27) {// Esc key
            var div = document.getElementById('versao-box');
            if (div.style.display == 'block') {
                $('#versao-box').hide();
            }
        }
    });

link.onclick = function(event) {
    $('#versao-box').on('click', function (event) {
        event.stopPropagation();
    });
    event.stopPropagation();
    var div = document.getElementById('versao-box');
    if (div.style.display !== 'block') {
        $(div).show();
    }
    else {
        $(div).hide();
    }
};

$( "#abrecard" ).on( "keydown", function(event) {
    if(event.which == 13)
        $(".card-reveal").css({"display": "block", "transform": "translateY(-100%)"});
});

$("#btn-accesibilidade").click(function() {
    $( "#menu-accesibilidade" ).toggle();
});
$("#fonte").click(function() {
    $( "#fonte-box" ).toggle("slow");
});
$("#audio").click(function() {
    $( "#audio-box" ).toggle("slow");
});
$('#zoom-in').click(function() {
    updateZoom(0.1);
});
$('#zoom-out').click(function() {
    updateZoom(-0.1);
});
$('#reset').click(function() {
    $('body').removeAttr('style');
});

zoomLevel = 1;
var updateZoom = function(zoom) {
    zoomLevel += zoom;
    $('body').css({ zoom: zoomLevel, '-moz-transform': 'scale(' + zoomLevel + ')' });
};

if(typeof(Storage) !== "undefined") {
    if (localStorage.changeColor === "true") {
        $("html").addClass("contraste");
    }
}
function opcaoDeConstraste() {
    if(typeof(Storage) !== "undefined") {
        console.log(typeof(localStorage.changeColor))
        if (localStorage.changeColor == "false") {
            localStorage.changeColor = true;
                $("html").addClass("contraste");
        } else {
            localStorage.changeColor = false;
                $("html").removeClass("contraste");

        }
    }
}
