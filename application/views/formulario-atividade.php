{% extends 'layout/base.php' %}
{% block title %}Atividades{% endblock %}

{% block content %}
<div class="card">
    <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-cubes"></i> Atividades - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <form id="formulario-atividade">
                    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
                    <input type="hidden" id="atividade_id" name="atividade_id" value="{% if atividade.atividade_id is defined %}{{ atividade.atividade_id }}{% endif %}">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="data_atividade">Data</label>
                                <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="data_atividade" data-target="#datetimepicker1" autofocus value="{% if atividade.data is defined %}{{ atividade.data }}{% endif %}"/>
                                    <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                        <div class="input-group-text bg-secondary text-white border-0"><i class="far fa-calendar-alt"></i></div>
                                    </div>
                                </div>
                                <span class="span-invalido data_atividade-feed"></span>
                            </div>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="row"> -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="horas_inicio">Horas início</label>
                                <div class="input-group date" id="datetimepicker2" data-target-input="nearest">
                                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="horas_inicio" data-target="#datetimepicker2" value="{% if atividade.horas_inicio is defined %}{{ atividade.horas_inicio }}{% endif %}"/>
                                    <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                        <div class="input-group-text bg-secondary text-white border-0"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <span class="span-invalido horas_inicio-feed"></span>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="horas_termino">Horas término</label>
                                <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="horas_termino" data-target="#datetimepicker3" value="{% if atividade.horas_termino is defined %}{{ atividade.horas_termino }}{% endif %}"/>
                                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                        <div class="input-group-text bg-secondary text-white border-0"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <span class="span-invalido horas_termino-feed"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="atividade">Atividade</label>
                        <textarea class="form-control form-control-sm" rows="3" placeholder="Informe a atividade" id="atividade" name="atividade">{% if atividade.atividade is defined %}{{ atividade.atividade }}{% endif %}</textarea>
                        <div class="invalid-feedback">Por favor, informe a atividade.</div>
                    </div>
                    {% if constant('USUARIO_NIVEL') == 0 %}
                    <div class="form-group aluno-feedback">
                        <label for="aluno_ra">Aluno | RA</label>
                        <select id="aluno_ra">
                            <option></option>
                            {% for aluno in alunos %}
                            <option value="{{ aluno.aluno_ra }}"{% if aluno.aluno_ra == atividade.aluno_ra %} selected="selected"{% endif %}>{{ aluno.nome }} | {{ aluno.aluno_ra }}</option>
                            {% endfor %}
                        </select>
                        <span class="span-invalido aluno-feed"></span>
                    </div>
                    {% endif %}
                    <div class="form-group categoria-feedback">
                        <label for="categoria_id">Categoria</label>
                        <select id="categoria_id">
                            <option></option>
                            {% for categoria in categorias %}
                            <option value="{{ categoria.categoria_id }}"{% if categoria.categoria_id == atividade.categoria_id %} selected="selected"{% endif %}>{{ categoria.categoria }}</option>
                            {% endfor %}
                        </select>
                        <span class="span-invalido categoria-feed"></span>
                    </div>
                    <div class="form-group modalidade-feedback">
                        <label for="modalidade_id">Modalidade</label>
                        <select id="modalidade_id">
                            <option></option>
                            {% for modalidade in modalidades if modalidade.modalidade_id == atividade.modalidade_id %}
                            <option value="{{ modalidade.modalidade_id }}" selected="selected">{{ modalidade.modalidade }}</option>
                            {% else %}
                            {% for modalidade in modalidades %}
                            <option value="{{ modalidade.modalidade_id }}"{% if modalidade.modalidade_id == atividade.modalidade_id %} selected="selected"{% endif %}>{{ modalidade.modalidade }}</option>                            
                            {% endfor %}
                            {% endfor %}
                        </select>
                        <span class="span-invalido modalidade-feed"></span>
                    </div>
                    {% if constant('USUARIO_NIVEL') == 0 %}
                    <div class="form-group">
                        <label for="validacao">Validação</label>
                        <select class="custom-select custom-select-sm" id="validacao" name="validacao">
                            <option value="0"{% if atividade.validacao is defined and atividade.validacao == 0 %} selected="selected"{% endif %}>Aguardando validação</option>
                            <option value="1"{% if atividade.validacao is defined and atividade.validacao == 1 %} selected="selected"{% endif %}>Válido</option>
                        </select>
                    </div>
                    {% endif %}
                    <div class="form-group">
                        <div class="custom-file" lang="en">
                            <input type="file" class="custom-file-input" id="imagem_comprovante" name="imagem_comprovante">
                            <div class="invalid-feedback">Por favor, informe a imagem do comprovante.</div>
                            <label class="custom-file-label" for="imagem_comprovante">Imagem do comprovante</label>
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
            <div class="col-6">
                {% if acao == 'editar' and atividade.imagem_comprovante is not empty %}
                {% set extensao = atividade.imagem_comprovante|slice(-3) %}
                <div class="row">
                    {% if extensao != 'pdf' %}
                    <div class="col-md-6 offset-md-3"><a class="btn btn-info" href="{{ constant('BASE_URL') }}comprovantes/{{ atividade.imagem_comprovante }}" data-lightbox="image-1">Visualizar imagem</a></div>
                    {% else %}
                    <div class="col-md-6 offset-md-3"><a class="btn btn-info" href="{{ constant('BASE_URL') }}comprovantes/{{ atividade.imagem_comprovante }}" target="_blank">Visualizar imagem</a></div>                    
                    {% endif %}
                </div>
                {% endif %}
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
{{ parent() }}
<script src="{{ constant('BASE_URL') }}assets/app/atividade.js"></script>
<script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}
