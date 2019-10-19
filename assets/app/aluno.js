var base_url = "http://localhost:8000/";
// var base_url = "https://silverio.herokuapp.com/";
var $table = $("#alunos");

$(function(){
    $table.bootstrapTable({
        url: base_url + "admin/aluno/listar",
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
        sortName: "nome",
        sortOrder: "asc",
        pageList: [10, 25, 50, 100],
        pageSize: 10,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            {field: "selecionado", checkbox: true},
            {field: "aluno_ra", title: "RA"},
            {field: "email", title: "Email"},
            {field: "nome", title: "Aluno", sortable: true}
        ],
        responseHandler: function (data) {
            return {
                total: data.total,
                rows: data.alunos
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }
    });
    $("#curso_id").select2({
        placeholder: "Selecione o curso",
        theme: "bootstrap",
        width: "94%"
    });
});

$("#formulario-aluno").on("submit", function () {
    var acao = $("#acao").val();
    var usuario_id = $("#usuario_id").val();
    var nome = $("#nome").val();
    var email = $("#email").val();
    var aluno_ra = $("#aluno_ra").val();
    var senha = $("#senha").val();
    var curso_id = $("#curso_id").val();
    if (nome.length === 0) {
        $("#nome").addClass("is-invalid");
        $("#nome").focus();
        return false;
    } else if (email.length === 0) {
        $("#email").addClass("is-invalid");
        $("#email").focus();
        return false;
    } else if (senha.length === 0 && acao == "adicionar") {
        $("#senha").addClass("is-invalid");
        $("#senha").focus();
        return false;
    } else if (aluno_ra.length === 0) {
        $("#aluno_ra").addClass("is-invalid");
        $("#aluno_ra").focus();
        return false;
    } else if (curso_id.length === 0) {
        $(".curso-feedback").addClass("has-error");
        $("#curso_id").focus();
        $(".curso-feed").html("<small>Por favor, informe o curso.</small>");
        $(".curso-feed").show();
        return false;
    } else {
        $(".btn-salvar-loading").show();
        $.post({
            url: base_url + "admin/aluno/salvar",
            dataType: "JSON",
            data: {acao: acao, usuario_id: usuario_id, nome: nome, email: email, senha: senha, aluno_ra: aluno_ra, curso_id: curso_id}
        })
        .done(function (data) {
            if (data.sucesso) {
                window.location.href = base_url + "admin/aluno";
            } else {
                $(".invalid-feedback").html("Email já cadastrado.");
                $("#email").addClass("is-invalid");
                $("#email").focus();
            }
            $(".btn-salvar-loading").hide();
        });
    }
    return false;
});


$("#btn-cancelar").on("click", function () {
    $(".btn-cancelar-loading").show();
    window.location.href = base_url + "admin/aluno";
});

$("#btn-editar").on("click", function(){
    var ids = getIdSelections();
    window.location.href = base_url + "admin/aluno/editar/" + ids[0];
});

$("#btn-excluir").on("click", function(){
    iziToast.show({
        title: "<p class='text-white'>Confirmação</p>",
        message: "<p class='text-white'>Deseja realmente excluir o(s) aluno(s) selecionado(s)?</p>"
    });
});

function excluir() {
    var ids = getIdSelections();
    $.post({
        url: base_url + "admin/aluno/excluir",
        dataType: "JSON",
        data: {ids: ids}
    })
    .done(function (data) {
        if (data.sucesso) {
            $table.bootstrapTable("remove", {
                field: "usuario_id",
                values: ids
            });
            $table.bootstrapTable("refresh", {silent: true});
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
    });
}

function getIdSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
        return row.usuario_id
    });
}
