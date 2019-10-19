{% extends "layout/base.php" %}
{% block title %}Comprovantes{% endblock %}

{% block content %}
<div class="card">
  <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-certificate"></i> Comprovantes - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
    <div class="card-body">
      <div class="row">
        <div class="col-6">
          <form id="formulario-comprovante">
          <input type="hidden" id="acao" name="acao" value="{{ acao }}">
          <input type="hidden" id="comprovante_id" name="comprovante_id" value="{% if comprovante.comprovante_id is defined %}{{ comprovante.comprovante_id }}{% endif %}">
          <div class="form-group">
            <label for="comprovante">Comprovante</label>
            <input type="text" class="form-control form-control-sm" id="comprovante" name="comprovante" autofocus placeholder="Informe o comprovante" value="{% if comprovante.comprovante is defined %}{{ comprovante.comprovante }}{% endif %}">
            <div class="invalid-feedback">Por favor, informe o comprovante.</div>
          </div>
          <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Salvar
            <span class="spinner-border spinner-border-sm btn-salvar-loading"></span>
          </button>
          <button type="button" class="btn btn-secondary btn-sm" id="btn-cancelar"><i class="fas fa-undo"></i> Cancelar
            <span class="spinner-border spinner-border-sm btn-cancelar-loading"></span>
          </button>
        </form>  
      </div>
    </div>
  </div>
</div>
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/app/comprovante.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}
