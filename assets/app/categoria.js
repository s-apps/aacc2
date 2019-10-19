var base_url = "http://localhost:8000/";
// var base_url = "https://silverio.herokuapp.com/";
var $table = $("#categorias");

$(function(){
    $table.bootstrapTable({
        url: base_url + "admin/categoria/listar",
        queryParamsType: "limit",
        queryParams: queryParams,
        sidePagination: "server",
        showRefresh: false,
        showColumns: false,
        showToggle: false,
        pagination: true,
        trimOnSearch: false,
        clickToSelect: true,
        search: true,
        sortName: "categoria",
        sortOrder: "asc",
        pageList: [10, 25, 50, 100],
        pageSize: 10,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        trimOnSearch: false,
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "categoria", title: "Categoria", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.categorias
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }              
    });   
});

$("#formulario-categoria").on("submit", function(){
    var categoria_id = $("#categoria_id").val();
    var categoria = $("#categoria").val();
    var acao = $("#acao").val();
    $("#categoria").removeClass("is-invalid");
    if(categoria.length === 0){
        $("#categoria").addClass("is-invalid");
        $("#categoria").focus();
        return false;
    }else{
        $(".btn-salvar-loading").show();
        $.post({
            url: base_url + "admin/categoria/salvar",
            dataType: "JSON",
            data: { categoria_id: categoria_id, categoria: categoria, acao: acao }
        })
        .done(function(data){
            if(data.sucesso){
                window.location.href = base_url + "admin/categoria";
            }else{
                $(".invalid-feedback").html("A categoria já existe");
                $("#categoria").addClass("is-invalid");
                $("#categoria").focus();
            }
            $(".btn-salvar-loading").hide();
        });
    }
    return false;
});

$("#btn-cancelar").on("click", function(){
    $(".btn-cancelar-loading").show();
    window.location.href = base_url + "admin/categoria";
});

$("#btn-excluir").on("click", function(){
    iziToast.show({
        title: "<p class='text-white'>Confirmação</p>",
        message: "<p class='text-white'>Deseja realmente excluir a(s) categoria(s) selecionada(s)?</p>"
    });
});

$("#btn-editar").on("click", function(){
    var ids = getIdSelections();
    window.location.href = base_url + "admin/categoria/editar/" + ids[0];
});

function excluir(){
    var ids = getIdSelections();
    $.post({
        url: base_url + "admin/categoria/excluir",
        dataType: "JSON",
        data: { ids: ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "categoria_id",
                values: ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
    });
}

function getIdSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
      return row.categoria_id
    });
}