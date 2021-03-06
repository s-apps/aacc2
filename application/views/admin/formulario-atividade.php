{% extends 'layout/base.php' %}
{% block title %}Dashboard{% endblock %}

{% block content %}
<div class="card">
    <div class="card-header py-2 bg-secondary text-white">
        <i class="fas fa-cubes"></i> Atividades - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}
    </div>
    <div class="card-body">
        <form id="formulario-atividade" enctype="multipart/form-data" method="POST">
            <div class="row">
                <div class="col-6">
                    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
                    <input type="hidden" id="atividade_id" name="atividade_id" value="{% if atividade.atividade_id is defined %}{{ atividade.atividade_id }}{% endif %}">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="data_atividade">Data</label>
                                <div class="input-group date" id="dataatividade" data-target-input="nearest">
                                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="data_atividade" data-target="#dataatividade" autofocus value="{% if atividade.data is defined %}{{ atividade.data }}{% endif %}"/>
                                    <div class="input-group-append" data-target="#dataatividade" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                                <span class="span-invalido data_atividade-feed"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="horas_inicio">Horas início</label>
                                <div class="input-group date" id="horasinicio" data-target-input="nearest">
                                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="horas_inicio" data-target="#horasinicio" value="{% if atividade.horas_inicio is defined %}{{ atividade.horas_inicio }}{% endif %}"/>
                                    <div class="input-group-append" data-target="#horasinicio" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <span class="span-invalido horas_inicio-feed"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="horas_termino">Horas término</label>
                                <div class="input-group date" id="horastermino" data-target-input="nearest">
                                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="horas_termino" data-target="#horastermino" value="{% if atividade.horas_termino is defined %}{{ atividade.horas_termino }}{% endif %}"/>
                                    <div class="input-group-append" data-target="#horastermino" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <span class="span-invalido horas_termino-feed"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group aluno-feedback"> 
                        <label for="aluno_ra">Aluno | RA</label>  
                        <select id="aluno_ra">
                            <option></option>
                            {% for aluno in alunos %}
                            <option value="{{ aluno.aluno_ra }}"{% if atividade.aluno_ra is defined and aluno.aluno_ra == atividade.aluno_ra %} selected="selected"{% endif %}>{{ aluno.nome }} | {{ aluno.aluno_ra }}</option>
                            {% endfor %}
                        </select>  
                        <span class="span-invalido aluno-feed"></span>
                    </div>
                    <div class="form-group">
                        <label for="atividade">Atividade</label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Informe a atividade" id="atividade" name="atividade">{% if atividade.atividade is defined %}{{ atividade.atividade }}{% endif %}</textarea>
                        <div class="invalid-feedback">Por favor, informe a atividade.</div>
                    </div>
                    <div class="form-group">
                        <label for="validacao">Situação</label>
                        <select class="custom-select custom-select-sm my-1 mr-sm-2" id="validacao">
                            <option value="0"{% if atividade.validacao is defined and atividade.validacao == 0 %} selected="selected"{% endif %}>Aguardando validação</option>
                            <option value="1"{% if atividade.validacao is defined and atividade.validacao == 1 %} selected="selected"{% endif %}>Válido</option>
                        </select>                    
                    </div>
                    <div class="form-group categoria-feedback"> 
                        <label for="categoria_id">Categoria</label>  
                        <select id="categoria_id">
                            {% for categoria in categorias %}
                            <option value="{{ categoria.categoria_id }}" {% if atividade.categoria_id is defined and atividade.categoria_id == categoria.categoria_id %} selected="selected"{% endif %}>{{ categoria.categoria }}</option>
                            {% endfor %}
                        </select>  
                        <span class="span-invalido categoria-feed"></span>
                    </div>
                    <div class="form-group modalidade-feedback"> 
                        <label for="modalidade_id">Modalidade</label>  
                        <select id="modalidade_id">
                        </select>  
                        <span class="span-invalido modalidade-feed"></span>
                    </div>
                    <div class="form-group comprovante-feedback"> 
                        <label for="comprovante_id">Comprovante</label>  
                        <select id="comprovante_id">
                        </select>  
                        <span class="span-invalido comprovante-feed"></span>
                    </div>
                    <div class="form-group">
                    <label for="imagem_comprovante">Imagem do comprovante</label> 
                        <div class="custom-file" lang="pt-br">
                            <input type="file" class="custom-file-input" id="imagem_comprovante" name="imagem_comprovante">
                            <div class="invalid-feedback">Por favor, informe a imagem do comprovante.</div>
                            <label class="custom-file-label" for="imagem_comprovante">Imagem do comprovante</label>
                        </div>
                    </div>
                </div>    
                <div class="col-6">
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
  <script src="{{ constant('BASE_URL') }}assets/app/atividade-admin.js"></script>
  <script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}