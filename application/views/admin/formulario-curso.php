{% extends 'layout/base.php' %}
{% block title %}Cursos{% endblock %}

{% block content %}
<div class="card">
    <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-graduation-cap"></i> Cursos - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <form id="formulario-curso">
                    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
                    <input type="hidden" id="curso_id" name="curso_id" value="{% if curso.curso_id is defined %}{{ curso.curso_id }}{% endif %}">
                    <div class="form-group">
                        <label for="curso">Curso</label>
                        <input type="text" class="form-control form-control-sm" id="curso" name="curso" autofocus placeholder="Informe o curso" value="{% if curso.curso is defined %}{{ curso.curso }}{% endif %}">
                        <div class="invalid-feedback">Por favor, informe o curso.</div>
                    </div>
                    <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-save"></i> Salvar
                        <span class="spinner-border spinner-border-sm btn-salvar-loading"></span>
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm" id="btn-cancelar"><i class="fas fa-undo"></i> Cancelar
                        <span class="spinner-border spinner-border-sm btn-cancelar-loading"></span>
                    </button>
                </form>
            </div>
        </div><!--row-->        
    </div>
</div>       
{% endblock %}

{% block scripts %}
{{ parent() }}
<script src="{{ constant('BASE_URL') }}assets/app/curso.js"></script>
<script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}