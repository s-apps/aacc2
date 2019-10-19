{% extends 'layout/base.php' %}
{% block title %}Professores{% endblock %}

{% block content %}
<div class="card">
    <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-users"></i> Professores - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <form id="formulario-professor">
                    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
                    <input type="hidden" id="usuario_id" name="usuario_id" value="{% if usuario.usuario_id is defined %}{{ usuario.usuario_id }}{% endif %}">
                    <div class="form-group">
                        <label for="nome">Nome completo</label>
                        <input type="text" class="form-control form-control-sm" id="nome" name="nome" autofocus placeholder="Informe o nome" value="{% if usuario.nome is defined %}{{ usuario.nome }}{% endif %}">
                        <div class="invalid-feedback">Por favor, informe o nome.</div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="Informe o email" value="{% if usuario.email is defined %}{{ usuario.email }}{% endif %}">
                                <div class="invalid-feedback">Por favor, informe o email.</div>
                            </div>
                        </div><!--col-8-->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="senha">Senha</label>
                                <input type="password" class="form-control form-control-sm" id="senha" name="senha" placeholder="Informe a senha">
                                <div class="invalid-feedback">Por favor, informe a senha.</div>
                            </div>
                        </div><!--col-4-->
                    </div><!--row-->
                    <div class="card mb-3">
                        <div class="card-header p-2">
                            Cursos
                        </div>
                        <div class="card-body p-2">
                            {% for curso in cursos %}
                            <div class="custom-control custom-checkbox mb-1 ml-1">
                                <input type="checkbox" class="custom-control-input" name="cursos[]" id="{{ curso.curso_id }}" value="{{ curso.curso_id }}" {% if curso.curso_id in cursosProfessor %}checked{% endif %}>
                                <label class="custom-control-label" for="{{ curso.curso_id }}">{{ curso.curso }}</label>
                            </div>
                            {% endfor %}
                        </div>
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
        {% endblock %}

        {% block scripts %}
        {{ parent() }}
        <script src="{{ constant('BASE_URL') }}assets/app/professor.js"></script>
        <script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
        {% endblock %}

