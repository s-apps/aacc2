{% extends 'layout/base.php' %}
{% block title %}Alunos{% endblock %}

{% block content %}
<div class="card">
    <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-graduation-cap"></i> Alunos - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
    <div class="card-body">
        <div id="toolbar">
            <a class="btn btn-secondary btn-sm" href="{{ constant('BASE_URL') }}admin/aluno/adicionar">
                <i class="fas fa-plus-circle"></i> Adicionar
            </a>
            <button class="btn btn-secondary btn-sm" id="btn-editar"><i class="fas fa-edit"></i> Editar</button>
            <button class="btn btn-danger btn-sm" id="btn-excluir"><i class="fas fa-minus-circle"></i> Excluir</button>        
        </div>
        <table id="alunos"></table>
    </div>
</div>            
{% endblock %}

{% block scripts %}
{{ parent() }}
<script src="{{ constant('BASE_URL') }}assets/app/aluno.js"></script>
<script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}