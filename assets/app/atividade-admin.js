var $table = $("#atividades");
var base_url = "http://localhost:8000/";

$(function(){
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
    $("#dataatividade").datetimepicker({
      format: "L",
      date: moment(),
      allowInputToggle: true
    });  
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
      placeholder: "Selecione a categoria",
      theme: "bootstrap",
      width: "100%"
    });

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