var base_url = "http://localhost:8000/";
// var base_url = "https://silverio.herokuapp.com/";
var $table = $("#comprovantes");

$(function(){
    $table.bootstrapTable({
        url: base_url + "admin/comprovante/listar",
        queryParamsType: "limit",
        queryParams : queryParams,
        sidePagination: "server",
        showRefresh: false,
        showColumns: false,
        showToggle: false,
        pagination: true,
        trimOnSearch: false,
        clickToSelect: true,
        search: true,
        sortName: "comprovante",
        sortOrder: "asc",
        pageList: [10, 25, 50, 100],
        pageSize: 10,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        trimOnSearch: false,
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "comprovante", title: "Comprovante", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.comprovantes
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }              
    });       
});

$("#formulario-comprovante").on("submit", function(){
    $("#comprovante").removeClass("is-invalid");
    var comprovante_id = $("#comprovante_id").val();
    var comprovante = $("#comprovante").val();
    var acao = $("#acao").val();
    if(comprovante.length === 0){
        $("#comprovante").addClass("is-invalid");
        $("#comprovante").focus();
        return false;
    }else{
        $(".btn-salvar-loading").show();
        $.post({
            url: base_url + "admin/comprovante/salvar",
            dataType: "JSON",
            data: { comprovante_id: comprovante_id, comprovante: comprovante, acao: acao }
        })
        .done(function(data){
            if(data.sucesso){
                window.location.href = base_url + "admin/comprovante";
            }else{
                $(".invalid-feedback").html("O comprovante já existe");
                $("#comprovante").addClass("is-invalid");
                $("#comprovante").focus();
            }
            $(".btn-salvar-loading").hide();
        });
    }
    return false;
});

$("#btn-editar").on("click", function(){
    var ids = getIdSelections();
    window.location.href = base_url + "admin/comprovante/editar/" + ids[0];
});

function editar(){
    var ids = getIdSelections();
    window.location.href = base_url + "admin/comprovante/editar/" + ids[0];
}

function getIdSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
      return row.comprovante_id
    });
}

function excluir(){
    var ids = getIdSelections();
    $.post({
        url: base_url + "admin/comprovante/excluir",
        dataType: "JSON",
        data: { ids: ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "comprovante_id",
                values: ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
    });
}

$("#btn-excluir").on("click", function(){
    iziToast.show({
        title: "<p class='text-white'>Confirmação</p>",
        message: "<p class='text-white'>Deseja realmente excluir o(s) comprovante(s) selecionado(s)?</p>"
    });
});

$("#btn-cancelar").on("click", function(){
    $(".btn-cancelar-loading").show();
    window.location.href = base_url + "admin/comprovante";
});

