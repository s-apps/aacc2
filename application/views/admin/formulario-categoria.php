{% extends "layout/base.php" %}
{% block title %}Categorias{% endblock %}

{% block content %}
<div class="card">
  <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-th-large"></i> Categorias - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
    <div class="card-body">
      <div class="row">
        <div class="col-6">
          <form id="formulario-categoria">
          <input type="hidden" id="acao" name="acao" value="{{ acao }}">
          <input type="hidden" id="categoria_id" name="categoria_id" value="{% if categoria.categoria_id is defined %}{{ categoria.categoria_id }}{% endif %}">
          <div class="form-group">
            <label for="categoria">Categoria</label>
            <input type="text" class="form-control form-control-sm" id="categoria" name="categoria" autofocus placeholder="Informe a categoria" value="{% if categoria.categoria is defined %}{{ categoria.categoria }}{% endif %}">
            <div class="invalid-feedback">Por favor, informe a categoria.</div>
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
  <script src="{{ constant('BASE_URL') }}assets/app/categoria.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}
