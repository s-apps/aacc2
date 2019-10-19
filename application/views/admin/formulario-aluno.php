{% extends 'layout/base.php' %}
{% block title %}Alunos{% endblock %}

{% block content %}
<div class="card">
    <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-graduation-cap"></i> Alunos - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <form id="formulario-aluno">
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
                    <div class="form-group">
                        <label for="aluno_ra">RA</label>
                        <input type="text" class="form-control form-control-sm" id="aluno_ra" name="aluno_ra" placeholder="Informe o RA" value="{% if usuario.aluno_ra is defined %}{{ usuario.aluno_ra }}{% endif %}">
                        <div class="invalid-feedback">Por favor, informe o RA.</div>
                    </div>
                    <div class="form-group curso-feedback">
                        <label for="curso_id">Curso</label>
                        <div class="input-group">
                            <select id="curso_id">
                                <option></option>
                                {% for curso in cursos %}
                                <option value="{{ curso.curso_id }}"{% if curso.curso_id == usuario.curso_id %} selected="selected"{% endif %}>{{ curso.curso }}</option>
                                {% endfor %}
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-secondary btn-sm add-curso" type="button"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <span class="span-invalido curso-feed"></span>    
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

<!-- Modal -->
<div class="modal fade" id="adicionar-curso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar curso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario-adicionar-curso-extra">
                    <div class="form-group">
                        <label for="curso">Curso</label>
                        <input type="text" class="form-control form-control-sm" id="curso" name="curso" placeholder="Informe o curso">
                        <div class="invalid-feedback">Por favor, informe o curso.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary btn-sm" id="btn-salvar-extra-curso"><i class="fas fa-save"></i> Salvar</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-undo"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>    
{% endblock %}

{% block scripts %}
{{ parent() }}
<script src="{{ constant('BASE_URL') }}assets/app/aluno.js"></script>
<script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}