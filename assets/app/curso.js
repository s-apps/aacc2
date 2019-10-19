var base_url = "http://localhost:8000/";
// var base_url = "https://silverio.herokuapp.com/";
var $table = $("#cursos");

$(function(){
    $table.bootstrapTable({
        url: base_url + "admin/curso/listar",
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
        sortName: "curso",
        sortOrder: "asc",
        pageList: [10, 25, 50, 100],
        pageSize: 10,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        trimOnSearch: false,
        toolbar: "#toolbar",
        columns: [
            {field: "selecionado", checkbox: true},
            {field: "curso", title: "Curso", sortable: true}
        ],
        responseHandler: function (data) {
            return {
                total: data.total,
                rows: data.cursos
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }
    });
});

$("#formulario-curso").on("submit", function () {
    $("#curso").removeClass("is-invalid");
    var curso_id = $("#curso_id").val();
    var curso = $("#curso").val();
    var acao = $("#acao").val();
    if (curso.length === 0) {
        $("#curso").addClass("is-invalid");
        $("#curso").focus();
        return false;
    } else {
        $(".btn-salvar-loading").show();
        $.post({
            url: base_url + "admin/curso/salvar",
            dataType: "JSON",
            data: {curso_id: curso_id, curso: curso, acao: acao}
        })
        .done(function (data) {
            if (data.sucesso) {
                window.location.href = base_url + "admin/curso";
            } else {
                $(".invalid-feedback").html("O curso já existe");
                $("#curso").addClass("is-invalid");
                $("#curso").focus();
            }
            $(".btn-salvar-loading").hide();
        });
    }
    return false;
});

$("#btn-cancelar").on("click", function () {
    $(".btn-cancelar-loading").show();
    window.location.href = base_url + "admin/curso";
});

$("#btn-excluir").on("click", function(){
    iziToast.show({
        title: "<p class='text-white'>Confirmação</p>",
        message: "<p class='text-white'>Deseja realmente excluir o(s) curso(s) selecionado(s)?</p>"
    });
});

$("#btn-editar").on("click", function(){
    var ids = getIdSelections();
    window.location.href = base_url + "admin/curso/editar/" + ids[0];
});

function excluir(){
    var ids = getIdSelections();
    $.post({
        url: base_url + "admin/curso/excluir",
        dataType: "JSON",
        data: { ids: ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "curso_id",
                values: ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
    });
}

function getIdSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
      return row.curso_id
    });
}