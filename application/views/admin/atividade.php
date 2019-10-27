{% extends 'layout/base.php' %}
{% block title %}Dashboard{% endblock %}

{% block content %}
<div class="card">
    <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-cubes"></i> Atividades - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
        <div class="card-body">
            <div id="toolbar">
	            <a class="btn btn-secondary btn-sm" href="{{ constant('BASE_URL') }}admin/atividade/adicionar">
                    <i class="fas fa-plus-circle"></i> Adicionar
                </a>
                <button class="btn btn-secondary btn-sm" id="btn-editar"><i class="fas fa-edit"></i> Editar</button>
                <button class="btn btn-danger btn-sm" id="btn-excluir"><i class="fas fa-minus-circle"></i> Excluir</button>        
            </div>
            <table id="atividades"></table>
        </div>
    </div>
</div>            
{% endblock %}

{% block scripts %}
  {{ parent() }}
  <script src="{{ constant('BASE_URL') }}assets/app/atividade-admin.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}