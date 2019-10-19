var base_url = "http://localhost:8000/";
// var base_url = "https://silverio.herokuapp.com/";
var $table = $("#avisos");

$(function(){
    $table.bootstrapTable({
        url: base_url + "admin/dashboard/listarAvisos",
        queryParamsType: "limit",
        queryParams : queryParams,
        sidePagination: "server",
        showRefresh: false,
        showColumns: false,
        showToggle: false,
        pagination: true,
        clickToSelect: true,
        search: false,
        sortName: "data",
        sortOrder: "desc",
        pageList: [5, 10, 15, 20],
        pageSize: 5,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "data", title: "Data", sortable: true },
            { field: "titulo", title: "Título", sortable: true },
            { field: "aviso", title: "Aviso", sortable: true }
        ],
        responseHandler: function(data){
            return {
                total: data.total,
                rows: data.avisos
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }              
    });
    $(".btn-editar-loading").hide();
    $(".btn-excluir-loading").hide();
    $(".btn-salvar-loading").hide();
    $(".btn-salvar-limite-loading").hide();
    $("#btn-editar-aviso, #btn-excluir-aviso").prop("disabled", true);
    $("#btn-adicionar").click( adicionarAviso );
    $("#btn-editar").click( editarAviso );
    $("#btn-excluir").click( excluirAviso );
    $("#datetimepicker-data_aviso").datetimepicker({
        format: "L",
        date: moment(),
        allowInputToggle: true
    });
    getLimiteDeHorasAtividades();    

});

function getLimiteDeHorasAtividades(){
    $.get({
        url: base_url + "admin/dashboard/limiteDeHorasAtividades",
        dataType: "JSON"
    })
    .done(function(data){
        $("#limite").val(data.horas_atividades);
    });
}

function adicionarAviso(){
    $("#acao").val("adicionar");
    $("#formulario-avisos").modal("show");
}

$("#formulario-avisos").on("shown.bs.modal", function(e){
    $(".btn-editar-loading").hide();
    $("#titulo").focus();
});

function editarAviso(){
    $(".btn-editar-loading").show();
    var ids = getIdSelections();
    $.ajax({
        url: base_url + "admin/dashboard/editarAviso/" + ids[0],
        dataType: "JSON",
        method: "GET"
    })
    .done(function(data){
        $("#acao").val("editar");
        $("#aviso_id").val(data.aviso.aviso_id);
        $("#data_aviso").val(data.aviso.data);
        $("#titulo").val(data.aviso.titulo);
        $("#aviso").val(data.aviso.aviso);
        $("#titulo").focus();
        $("#formulario-avisos").modal("show");        
    });
}

function excluirAviso(){
    $(".btn-excluir-loading").show();
    var ids = getIdSelections();
    $.ajax({
        url: base_url + "admin/dashboard/excluirAviso",
        dataType: "JSON",
        method: "POST",
        data: { ids: ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "aviso_id",
                values: ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
        $(".btn-excluir-loading").hide();
    });
    return false;
}

function getIdSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
      return row.aviso_id
    });
}

$("body").on("submit", "#formulario-avisos", function(){
    var acao = $("#acao").val();
    var data_aviso = $("#data_aviso").val();
    var titulo = $("#titulo").val();
    var aviso = $("#aviso").val();
    var aviso_id = $("#aviso_id").val();
    $("#data_aviso").removeClass("is-invalid");
    $("#titulo").removeClass("is-invalid");
    $("#aviso").removeClass("is-invalid");
    $(".data_aviso-feed").html("");
    if(data_aviso.length === 0){
        $(".data_aviso-feed").html("<small>Por favor, informe a data.</small>");
        $("#data_aviso").addClass("is-invalid");
        $("#data_aviso").focus();
        return false;
    }else if(titulo.length === 0){
        $("#titulo").addClass("is-invalid");
        $("#titulo").focus();
        return false;
    }else if(aviso.length === 0){
        $("#aviso").addClass("is-invalid");
        $("#aviso").focus();
        return false;
    }else{
        $(".btn-salvar-loading").show();
        $.post({
            url: base_url + "admin/dashboard/salvarAviso",
            dataType: "JSON",
            data: { acao: acao, data_aviso: data_aviso, titulo: titulo, aviso: aviso, aviso_id: aviso_id }
        })
        .done(function(data){
            if(data.sucesso){
                $table.bootstrapTable("refresh", { silent: true });
                $("#formulario-avisos").modal("hide");
            }else{
                alert("erro");
            }
            $(".btn-salvar-loading").hide();
        });
    }
    return false;
});

$("#formulario-avisos").on("hidden.bs.modal", function (e) {
    $("#titulo").val("");
    $("#aviso").val("");
    $("#data_aviso").removeClass("is-invalid");
    $("#titulo").removeClass("is-invalid");
    $("#aviso").removeClass("is-invalid");
    $(".data_aviso-feed").html("");
    $("#btn-editar, #btn-excluir").prop("disabled", true);
    $(".btn-salvar-loading, .btn-cancelar-loading").hide();
    $table.bootstrapTable("uncheckAll");
});

$("#button-add-limite").on("click", function(){
    var limite = $("#limite").val();
    $("#limite").val("");
    $(".btn-salvar-limite-loading").show();
    $.post({
        url: base_url + "admin/dashboard/setLimiteDeHorasAtividades",
        dataType: "JSON",
        data: { limite: limite }
    })
    .done(function(data){
        if(data.sucesso){
            $("#limite").val(limite);
        }else{
            alert("erro");
        }
        $(".btn-salvar-limite-loading").hide();
    });
    return false;
});