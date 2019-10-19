var base_url = "http://localhost:8000/";
// var base_url = "https://silverio.herokuapp.com/";
var $table = $("#professores");

$(function(){
    $table.bootstrapTable({
        url: base_url + "admin/professor/listar",
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
        trimOnSearch: false,
        toolbar: "#toolbar",
        columns: [
            {field: "selecionado", checkbox: true},
            {field: "nome", title: "Professor", sortable: true},
            {field: "email", title: "Email"}
        ],
        responseHandler: function (data) {
            return {
                total: data.total,
                rows: data.professores
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }
    });
});

$("#formulario-professor").on("submit", function () {
    var usuario_id = $("#usuario_id").val();
    var nome = $("#nome").val();
    var email = $("#email").val();
    var senha = $("#senha").val();
    var acao = $("#acao").val();
    var cursos = [];
    $("input[name='cursos[]']:checked").each(function () {
        cursos.push($(this).val());
    });
    $("#nome").removeClass("is-invalid");
    $("#email").removeClass("is-invalid");
    $("#senha").removeClass("is-invalid");
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
    } else {
        $(".btn-salvar-loading").show();
        $.post({
            url: base_url + "admin/professor/salvar",
            dataType: "JSON",
            data: {acao: acao, usuario_id: usuario_id, nome: nome, email: email, senha: senha, cursos: cursos}
        })
        .done(function (data) {
            if (data.sucesso) {
                window.location.href = base_url + "admin/professor";
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

$("#btn-editar").on("click", function(){
    var ids = getIdSelections();
    window.location.href = base_url + "admin/professor/editar/" + ids[0];
});

function getIdSelections() {
    return $.map($table.bootstrapTable("getSelections"), function (row) {
        return row.usuario_id
    });
}

$("#btn-cancelar").on("click", function () {
    $(".btn-cancelar-loading").show();
    window.location.href = base_url + "admin/professor";
});

$("#btn-excluir").on("click", function(){
    iziToast.show({
        title: "<p class='text-white'>Confirmação</p>",
        message: "<p class='text-white'>Deseja realmente excluir o(s) curso(s) selecionado(s)?</p>"
    });
});

function excluir() {
    var ids = getIdSelections();
    $.post({
        url: base_url + "admin/professor/excluir",
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