var base_url = "http://localhost:8000/";
// var base_url = "https://silverio.herokuapp.com/";
var $table = $("#modalidades");

$(function(){
    $table.bootstrapTable({
        url: base_url + "admin/modalidade/listar",
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
        sortName: "modalidade",
        sortOrder: "asc",
        pageList: [10, 25, 50, 100],
        pageSize: 10,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        toolbar: "#toolbar",
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "modalidade", title: "Modalidade", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.modalidades
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }              
    });    
    $("#categoria_id").select2({
        placeholder: "Selecione a categoria",
        theme: "bootstrap",
        width: "94%"
    });
    $("#comprovante_id").select2({
        placeholder: "Selecione o comprovante",
        theme: "bootstrap",
        width: "94%"
    });

    var url = window.location.href;
    var segmentos = url.split("/");
    var segmento = segmentos[segmentos.length-2];
    if(segmento == "editar"){
        $("#datetimepicker3").datetimepicker({
            format: "HH:mm",
            allowInputToggle: true,
            icons: { up: "fas fa-plus", down: "fas fa-minus" },
            stepping: 10
        });
        $("#datetimepicker4").datetimepicker({
            format: "HH:mm",
            allowInputToggle: true,
            icons: { up: "fas fa-plus", down: "fas fa-minus" },
            stepping: 10
        });
    }else{
        $("#datetimepicker3").datetimepicker({
            date: moment("01:00", "HH:mm"),
            format: "HH:mm",
            allowInputToggle: true,
            icons: { up: "fas fa-plus", down: "fas fa-minus" },
            stepping: 10
        });
        $("#datetimepicker4").datetimepicker({
            date: moment("02:00", "HH:mm"),
            format: "HH:mm",
            allowInputToggle: true,
            icons: { up: "fas fa-plus", down: "fas fa-minus" },
            stepping: 10
        });
    }      
});

$("#formulario-modalidade").on("submit", function(){
    var acao = $("#acao").val();
    var modalidade_id = $("#modalidade_id").val();
    var modalidade = $("#modalidade").val();
    var categoria_id = $("#categoria_id").val();
    var duracao = $("#duracao").val();
    var limite = $("#limite").val();
    var comprovante_id = $("#comprovante_id").val();
    var split1 = duracao.split(":");
    var split2 = limite.split(":");
    var hora1 = (split1[0] * 60) + parseInt(split1[1]);
    var hora2 = (split2[0] * 60) + parseInt(split2[1]); 
    $(".categoria-feed").hide();
    $(".categoria-feedback").removeClass("has-error");
    $("#modalidade").removeClass("is-invalid");
    $(".duracao-feed").hide();
    $("#duracao").removeClass("is-invalid");
    $(".limite-feed").hide();
    $("#limite").removeClass("is-invalid");
    $(".comprovante-feed").hide();
    $(".comprovante-feedback").removeClass("has-error");

    if(categoria_id.length === 0){
        $(".categoria-feedback").addClass("has-error");
        $("#categoria_id").focus();
        $(".categoria-feed").html("<small>Por favor, informe a categoria.</small>");
        $(".categoria-feed").show();
        return false;
    }else if(modalidade.length === 0){
        $("#modalidade").addClass("is-invalid");
        $("#modalidade").focus();
        return false;
    }else if(duracao.length === 0){
        $("#duracao").addClass("is-invalid");
        $("#duracao").focus();
        $(".duracao-feed").html("<small>Por favor, informe a duração.</small>");
        $(".duracao-feed").show();
        return false;
    }else if(limite.length === 0){
        $("#limite").addClass("is-invalid");
        $("#limite").focus();
        $(".limite-feed").html("<small>Por favor, informe o limite.</small>");
        $(".limite-feed").show();
        return false;
    }else if(comprovante_id.length === 0){
        $(".comprovante-feedback").addClass("has-error");
        $("#comprovante_id").focus();
        $(".comprovante-feed").html("<small>Por favor, informe o comprovante.</small>");
        $(".comprovante-feed").show();
        return false;    
    }else if(hora1 == 0 || hora1 > hora2){
        iziToast.warning({
            close: true,
            timeout: false,
            position: "center",
            animateInside: false,
            icon: "",
            title: "<p class='text-white'>Atenção!</p>",
            message: "<p class='text-white'>Duração não pode ser 00:00<br/>Duração não pode ser maior que Limite</p>",
            buttons: [
                ["<button class='text-white' style='outline: none;'><b>OK</b></button>", function (instance, toast) {
                        instance.hide({transitionOut: "fadeOut"}, toast, "button");
                    }, true]
            ]
        });
        return false;        
    }else{
        $(".btn-salvar-loading").show();
        $.post({
            url: base_url + "admin/modalidade/salvar",
            dataType: "JSON",
            data: { acao: acao, modalidade_id: modalidade_id, modalidade: modalidade, categoria_id: categoria_id, comprovante_id: comprovante_id, duracao: duracao, limite: limite  }
        })
        .done(function(data){
            if(data.sucesso){
                window.location.href = base_url + "admin/modalidade";
            }else{
                iziToast.warning({
                    close: true,
                    timeout: false,
                    position: "center",
                    animateInside: false,
                    icon: "",
                    title: "<p class='text-white'>Atenção!</p>",
                    message: "<p class='text-white'>A modalidade já existe!</p>",
                    buttons: [
                        ["<button class='text-white' style='outline: none;'><b>OK</b></button>", function (instance, toast) {
                                instance.hide({transitionOut: "fadeOut"}, toast, "button");
                            }, true]
                    ]
                });
                $(".btn-salvar-loading").hide();
                return false;        
            }
            $(".btn-salvar-loading").hide();
        });
    }
   return false;
});

$("#btn-cancelar").on("click", function(){
    $(".btn-cancelar-loading").show();
    window.location.href = base_url + "admin/modalidade";
});

$("#btn-editar").on("click", function(){
    var ids = getIdSelections();
    window.location.href = base_url + "admin/modalidade/editar/" + ids[0];
});

$("#btn-excluir").on("click", function(){
    iziToast.show({
        title: "<p class='text-white'>Confirmação</p>",
        message: "<p class='text-white'>Deseja realmente excluir a(s) modalidade(s) selecionada(s)?</p>"
    });
});

function excluir(){
    var ids = getIdSelections();
    $.post({
        url: base_url + "admin/modalidade/excluir",
        dataType: "JSON",
        data: { ids: ids }
    })
    .done(function(data){
        if(data.sucesso){
            $table.bootstrapTable("remove", {
                field: "modalidade_id",
                values: ids
            });
            $table.bootstrapTable("refresh", { silent: true });
            $("#btn-editar, #btn-excluir").prop("disabled", true);
        }
    });
}

function getIdSelections(){
    return $.map($table.bootstrapTable("getSelections"), function(row){
       return row.modalidade_id 
    });
}