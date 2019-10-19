$(function(){
    $("div.search input[type=text]").addClass("form-control-sm");
    $("#btn-editar, #btn-excluir").prop("disabled", true);
    $(".btn-salvar-loading, .btn-cancelar-loading").hide();
});

iziToast.settings({
    close: true,
    layout: 2,
    color: "#dc3545",
    timeout: false,
    position: "topCenter",
    animateInside: false,
    buttons: [
        ["<button class='text-white'>Excluir</button>", function(instance, toast){
            instance.hide({ transitionOut: "fadeOut" }, toast, "btn-excluir");
        }],
        ["<button class='text-white'>Cancelar</button>", function(instance, toast){
            instance.hide({ transitionOut: "fadeOut"}, toast, "btn-cancelar");
        }]
    ],
    onClosing: function(instance, toast, closedBy){
        if(closedBy == "btn-excluir"){
            excluir();
        }
    }        
}); 

function queryParams(params) {
    return {
        limit: params.limit,
        offset: params.offset,
        sort: params.sort,
        order: params.order,
        search: params.search
    };
}

$table.on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table", function () {
    var tamanho = $table.bootstrapTable("getSelections").length;
    $("#btn-editar").prop("disabled", (tamanho == 0 || tamanho > 1) ? true : false);
    $("#btn-excluir").prop("disabled",  tamanho == 0);
});