var $table = $("#atividades");
var base_url = "http://localhost:8000/";
var url = window.location.href;
var segmentos = url.split('/');

$(function(){
    // var lastsegment = segmentos[segmentos.length-1];
    // console.log(segmentos[segmentos.length-1]);
    $table.bootstrapTable({
        url: base_url + "admin/atividade/listar",
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
        sortName: "atividade",
        sortOrder: "asc",
        pageList: [10, 25, 50, 100],
        pageSize: 10,
        theadClasses: "thead-light",
        classes: "table table-bordered table-sm table-hover",
        trimOnSearch: false,
        toolbar: "#toolbar",
        detailView: true,
        detailFormatter: detalhesFormatter,
        icons: window.icones,
        columns: [
            { field: "selecionado", checkbox: true },
            { field: "data", title: "Data", sortable: true },
            { field: "aluno_ra", title: "RA", sortable: true },
            { field: "nome", title: "Aluno", sortable: true },
            { field: "email", title: "Email", sortable: true }
        ],
        responseHandler: function ( data ) {
            return {
                total: data.total,
                rows: data.atividades
            };
        },
        formatLoadingMessage: function () {
            return "<span style='font-size: 0.85rem;margin: 5px;'>Carregando</span>";
        }              
    });    
    if(segmentos[segmentos.length-1] == 'adicionar'){
      $("#dataatividade").datetimepicker({
        format: "L",
        date: moment(),
        allowInputToggle: true
      });
    }  
    if(segmentos[segmentos.length-2] == 'editar'){
      $("#dataatividade").datetimepicker({
        format: "L",
        allowInputToggle: true
      });
    }
    $("#horasinicio").datetimepicker({
      format: "HH:mm",
      allowInputToggle: true
    });    
    $("#horastermino").datetimepicker({
      format: "HH:mm",
      allowInputToggle: true
    });    
    $("#aluno_ra").select2({
      placeholder: "Selecione o aluno",
      theme: "bootstrap",
      width: "100%"
    });
    $("#categoria_id").select2({
      theme: "bootstrap",
      width: "100%"
    });
    $("#categoria_id").prop("selectedIndex", 0).change();
    $("#modalidade_id").select2({
      theme: "bootstrap",
      width: "100%"
    });
    $("#comprovante_id").select2({
      theme: "bootstrap",
      width: "100%"
    });
    if(! segmentos[segmentos.length-1] == "atividade"){
      getModalidadesByCategoria();
    }
});

function detalhesFormatter(index, row){
    var html = [];
    html.push("<div class='card-group'>" +
    "<div class='card'>" +
      "<div class='card-body'>" +
        "<h5 class='card-title'>Atividade</h5>" +
        "<p class='card-text'>" + row.atividade + "</p>" +
      "</div>" +
    "</div>" +
    "<div class='card'>" +
      "<div class='card-body'>" +
        "<h5 class='card-title'>Modalidade</h5>" +
        "<p class='card-text'>" + row.modalidade + "</p>" + 
      "</div>" +
    "</div>" +
      "<div class='card'>" +
      "<div class='card-body'>" +
        "<h5 class='card-title'>Carga Horária</h5>" +
        "<p class='card-text'>" + row.carga_horaria + "</p>" + 
      "</div>" +
    "</div></div>");    
    return html.join("");
}

window.icones = 
{
    detailOpen: "fas fa-chevron-circle-right fa-lg",
    detailClose: "fas fa-chevron-circle-down fa-lg"
}

$("#btn-cancelar").on("click", function(){
  $(".btn-cancelar-loading").show();
  window.location.href = base_url + "admin/atividade";
});

function getModalidadesByCategoria(){
  var categoria_id = $("#categoria_id").val();
  $.get({
    url: base_url + "admin/atividade/getModalidadesByCategoria/" + categoria_id,
    dataType: "JSON"
  })
  .done(function(data){
    $("#modalidade_id").empty();
    $.each(data.modalidades, function(key, value){
      var newOption = new Option(value.modalidade, value.modalidade_id, true, true);
      $("#modalidade_id").append(newOption).trigger("change");
    });
    if(segmentos[segmentos.length-2] == "adicionar"){
      $("#modalidade_id").prop("selectedIndex", 0).change();
      getComprovanteByModalidade();
    }
  });
}

function getComprovanteByModalidade(){
  var modalidade_id = $("#modalidade_id").val();
  $.get({
    url: base_url + "admin/atividade/getComprovanteByModalidade/" + modalidade_id,
    dataType: "JSON"
  })
  .done(function(data){
    $("#comprovante_id").empty();
    var newOption = new Option(data.comprovante.comprovante, data.comprovante.comprovante_id, true, true);
    $("#comprovante_id").append(newOption).trigger("change");
  });
}

$("#categoria_id").on("change", function(){
  $("#modalidade_id").empty();
  $("#comprovante_id").empty();
  getModalidadesByCategoria();
});

$("#modalidade_id").on("change", function () {
  $("#comprovante_id").empty();
  getComprovanteByModalidade();
});

$("#formulario-atividade").on("submit", function(){
  var acao = $("#acao").val();
  var atividade_id = (acao == "adicionar") ? 0 : $("#atividade_id").val();
  var data_atividade = $("#data_atividade").val();
  var horas_inicio = $("#horas_inicio").val();
  var horas_termino = $("#horas_termino").val();
  var aluno_ra = $("#aluno_ra").val();
  var atividade = $("#atividade").val();
  var validacao = $("#validacao").val();
  var categoria_id = $("#categoria_id").val();
  var modalidade_id = $("#modalidade_id").val();
  var comprovante_id = $("#comprovante_id").val();
  var imagem_comprovante = $("#imagem_comprovante").val();
  if(camposValidos(data_atividade, horas_inicio, horas_termino, aluno_ra, atividade, /*validacao, categoria_id, modalidade_id, comprovante_id,*/ imagem_comprovante)){
    var data = new FormData(this);
    data.append("acao", acao);
    data.append("atividade_id", atividade_id);
    data.append("data_atividade", data_atividade);
    data.append("horas_inicio", horas_inicio);
    data.append("horas_termino", horas_termino);
    data.append("aluno_ra", aluno_ra);
    data.append("atividade", atividade);
    data.append("validacao", validacao);
    data.append("categoria_id", categoria_id);
    data.append("modalidade_id", modalidade_id);
    data.append("comprovante_id", comprovante_id);
    // data.append("imagem_comprovante", imagem_comprovante);
    $(".btn-salvar-loading").show();
    $.post({
      url: base_url + "admin/atividade/salvar",
      dataType: "JSON",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function(data){
        if(data.erro.length === 0){     
          window.location.href = base_url + "admin/atividade";
        }else{
          iziToast.warning({
            close: true,
            timeout: false,
            position: "center",
            animateInside: false,
            title: "Atenção",
            message: data.erro,
            buttons: [
                ["<button><b>OK</b></button>", function (instance, toast) {
                        instance.hide({transitionOut: "fadeOut"}, toast, "button");
                  }, true
                ]
            ]
          });
          $(".btn-salvar-loading").hide();
          return false;
        }
      },
      error: function(){
        $(".btn-salvar-loading").hide();
        console.log("erro servidor");
      }
    });   
    return false; 
  }
  return false;
});

function camposValidos(data_atividade, horas_inicio, horas_termino, aluno_ra, atividade/*, validacao, categoria_id, modalidade_id, comprovante_id, imagem_comprovante*/){
  var dataValida = moment(data_atividade, "DD/MM/YYYY", true).isValid();
  var horasInicio = moment(horas_inicio, "HH:mm", true).isValid();
  var horasTermino = moment(horas_termino, "HH:mm", true).isValid();
  $("#data_atividade").removeClass("is-invalid");
  $(".data_atividade-feed").hide();
  $("#horas_inicio").removeClass("is-invalid");
  $(".horas_inicio-feed").hide();
  $("#horas_termino").removeClass("is-invalid");
  $(".horas_termino-feed").hide();
  $(".aluno-feedback").removeClass("has-error");
  $(".aluno-feed").hide();
  $("#atividade").removeClass("is-invalid");
  $("#imagem_comprovante").removeClass("is-invalid");
  if(data_atividade.length === 0 || ! dataValida){
    $("#data_atividade").addClass("is-invalid");
    $("#data_atividade").focus();
    $(".data_atividade-feed").html("<small>Data inválida.</small>");
    $(".data_atividade-feed").show();    
    return false;
  }else if(horas_inicio.length === 0 || ! horasInicio){
    $("#horas_inicio").addClass("is-invalid");
    $("#horas_inicio").focus();
    $(".horas_inicio-feed").html("<small>Horas início inválida.</small>");
    $(".horas_inicio-feed").show();    
    return false;
  }else if(horas_termino.length === 0 || ! horasTermino){
    $("#horas_termino").addClass("is-invalid");
    $("#horas_termino").focus();
    $(".horas_termino-feed").html("<small>Horas término inválida.</small>");
    $(".horas_termino-feed").show();
    return false;
  }else if(horasValidas(horas_inicio, horas_termino)){
    iziToast.warning({
      close: true,
      timeout: false,
      position: "center",
      animateInside: false,
      title: "Atenção",
      message: "Horas término não pode ser menor ou igual horas início",
      buttons: [
          ["<button><b>OK</b></button>", function (instance, toast) {
                  instance.hide({transitionOut: "fadeOut"}, toast, "button");
            }, true
          ]
      ]
    });
    return false;
  }else if(aluno_ra.length === 0){
    $(".aluno-feedback").addClass("has-error");
    $("#aluno_ra").focus();
    $(".aluno-feed").html("<small>Por favor, informe o aluno.</small>");
    $(".aluno-feed").show();
    return false;    
  }else if(atividade.length === 0){
    $("#atividade").addClass("is-invalid");
    $("#atividade").focus();
    return false;
  }else if($("#imagem_comprovante")[0].files.length === 0){
    $("#imagem_comprovante").addClass("is-invalid");
    $("#imagem_comprovante").focus();
    return false;
  }
    return true;
}

$(".custom-file-input").on("change", function () {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

function horasValidas(horas_inicio, horas_termino){
  var split1 = horas_inicio.split(":");
  var split2 = horas_termino.split(":");
  var hora1 = (split1[0] * 60) + parseInt(split1[1]);
  var hora2 = (split2[0] * 60) + parseInt(split2[1]);
  return hora2 <= hora1;
}

$("#btn-editar").on("click", function(){
  var ids = getIdSelections();
  window.location.href = base_url + "admin/atividade/editar/" + ids[0];
});

function getIdSelections() {
  return $.map($table.bootstrapTable("getSelections"), function (row) {
    return row.atividade_id
  });
}