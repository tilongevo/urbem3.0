$(document).ready(function() {
    $(window).resize(function() {
        verificaQuantidadeIconesDentroMenuDropdownActions();
    });

    function removeClassShowInDropdownList(objectTarget) {
        objectTarget.removeClass("show-list-action-group");
        objectTarget.hide();
    }

    function disabledAnotherListActionOpen() {
        $(".sonata-ba-list-field-actions").each(function() {
            var listActions = $(this).find(".btn-group-list-actions-dropdown").find("div");
            removeClassShowInDropdownList(listActions);
        });
    }

    $(".dropdown-toggle-custom").click(function () {
        var listActions = $(this).parent().find("div");
        if (listActions.hasClass("show-list-action-group")) {
            removeClassShowInDropdownList(listActions);
            return;
        }

        disabledAnotherListActionOpen();
        listActions.show();
        listActions.addClass("show-list-action-group");
    });

    function verificaQuantidadeIconesDentroMenuDropdownActions() {
        var larguraPadraoDeCadaIcone = 24; // representacao em PX
        var exibeIconesDeActionsAgrupado = false;

        $(".sonata-ba-list-field-actions").each(function() {
            var larguraDaTD = $(this).find(".btn-group-list-actions-dropdown").parent().width();
            var quantidadeDeIcones = $(this).find(".btn-group-list-actions-dropdown").find("div > a").length;

            if ((quantidadeDeIcones * larguraPadraoDeCadaIcone) > larguraDaTD) {
                exibeIconesDeActionsAgrupado = true;
                $(".dados-agrupados").show();
                $(".dados-abertos").hide();

                return;
            }

            if (!exibeIconesDeActionsAgrupado) {
                $(".dados-agrupados").hide();
                $(".dados-abertos").show();

                return;
            }
        });
    }
    verificaQuantidadeIconesDentroMenuDropdownActions();

    function posicionaInputsSelect2MultipleOptionsCustomized() {
        if (!parseInt($('form').length) > 0) {
            return;
        }

        $("input.select2-multiple-options-custom, select.select2-multiple-options-custom").each(function() {
            var parentElement = $(this).parent().parent();
            parentElement.addClass("select2-container-multi-options-overflow");
        });
    }
    posicionaInputsSelect2MultipleOptionsCustomized();

    /**
     * Esta função está duplicada, o conteúdo dela deve ser replicado em:
     * src/Urbem/CoreBundle/Resources/public/javascripts/urbem-sonata.js
    * */
    function changeCustomClassNameCSSFromParentElement() {
        if (!parseInt($('form').length) > 0) {
            return;
        }

        $("input[type=text].select2-focusser.select2-offscreen").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-select");
        });

        $("input[type=text].campo-sonata.form-control").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-input-text");
        });

        $("input[type=number].campo-sonata.form-control").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-input-number");
        });

        $("input[type=file]").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-input-file");
        });

        $("input[type=text].sonata-medium-datecampo-sonata.form-control").each(function() {
            $(this).parents(".campo-sonata").first().toggleClass("campo-sonata campo-sonata-datecampo");
        });

        $("input[type=radio].my-radio").each(function() {
            $(this).parents(".s3.field-filtro").first().toggleClass("s3 s12").addClass("filtro-sonata-custom");
        });
    }
    changeCustomClassNameCSSFromParentElement();
});