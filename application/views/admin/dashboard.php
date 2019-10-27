{% extends 'layout/base.php' %}
{% block title %}Dashboard{% endblock %}

{% block content %}
<div class="row">
  <div class="col-6">
    <div class="card">
      <div class="card-header py-2 bg-secondary text-white">Avisos</div>
      <div class="card-body">
        <div id="toolbar">
		    <button class="btn btn-secondary btn-sm" id="btn-adicionar"><i class="fas fa-plus-circle"></i> Adicionar</button>
            <button class="btn btn-secondary btn-sm" id="btn-editar" data-toggle="modal"><i class="fas fa-edit"></i> Editar <span class="spinner-border spinner-border-sm btn-editar-loading"></span></button>
            <button class="btn btn-danger btn-sm" id="btn-excluir"><i class="fas fa-minus-circle"></i> Excluir <span class="spinner-border spinner-border-sm btn-excluir-loading"></span></button>        
        </div>
        <table id="avisos"></table> 
      </div>
    </div>  
  </div>
  <div class="col-6">
    <div class="card">
      <div class="card-header py-2 bg-secondary text-white">Configurações</div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6 offset-md-0">
            <label for="limite">Limite de horas atividades</label>
            <div class="input-group input-group-sm">
              <input type="text" class="form-control" aria-describedby="button-add-limite" id="limite">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary bg-secondary text-white border-0" type="button" id="button-add-limite"><i class="fas fa-save"></i> Salvar <span class="spinner-border spinner-border-sm btn-salvar-limite-loading"></span></button>
              </div>
            </div> 
          </div>
        </div>     
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="formulario-avisos" tabindex="-1" role="dialog" aria-labelledby="avisosLabel" aria-hidden="true">
  <form id="formulario-avisos">
    <input type="hidden" id="acao" name="acao" value="">
    <input type="hidden" id="aviso_id" name="aviso_id" value="">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="avisosLabel">Avisos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="data_aviso">Data</label>
              <div class="input-group date" id="datetimepicker-data_aviso" data-target-input="nearest">
                <input type="text" class="form-control form-control-sm datetimepicker-input" id="data_aviso" data-target="#datetimepicker-data_aviso"/>
                <div class="input-group-append" data-target="#datetimepicker-data_aviso" data-toggle="datetimepicker">
                  <div class="input-group-text bg-secondary text-white border-0"><i class="far fa-calendar-alt"></i></div>
                </div>
              </div>
              <span class="span-invalido data_aviso-feed"></span>
          </div>
          <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" class="form-control form-control-sm" id="titulo" name="titulo" placeholder="Informe o título" value="">
            <div class="invalid-feedback">Por favor, informe o título.</div>
          </div>
          <div class="form-group">
            <label for="aviso">Aviso</label>
            <textarea class="form-control form-control-sm" rows="3" placeholder="Informe o aviso" id="aviso" name="aviso"></textarea>
            <div class="invalid-feedback">Por favor, informe o aviso.</div>
          </div>   
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-secondary btn-sm" id="btn-salvar"><i class="fas fa-save"></i> Salvar <span class="spinner-border spinner-border-sm btn-salvar-loading"></span></button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-undo"></i> Cancelar</button>
      </div>
    </div>
  </div>
</form>
</div>
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/app/dashboard-admin.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}