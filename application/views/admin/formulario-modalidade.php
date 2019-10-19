{% extends "layout/base.php" %}
{% block title %}Modalidades{% endblock %}

{% block content %}
<div class="card">
    <div class="card-header py-2 bg-secondary text-white"><i class="fas fa-th"></i> Modalidades - {% if acao == 'adicionar' %}adicionando{% elseif acao == 'editar' %}editando{% else %}listando{% endif %}</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <form id="formulario-modalidade">
                    <input type="hidden" id="acao" name="acao" value="{{ acao }}">
                    <input type="hidden" id="modalidade_id" name="modalidade_id" value="{% if modalidade.modalidade_id is defined %}{{ modalidade.modalidade_id }}{% endif %}">    
                    <div class="form-group categoria-feedback">
                        <label for="categoria_id">Categoria</label>
                        <div class="input-group">
                            <select id="categoria_id">
                                <option></option>
                                {% for categoria in categorias %}
                                <option value="{{ categoria.categoria_id }}"{% if categoria.categoria_id == modalidade.categoria_id %} selected="selected"{% endif %}>{{ categoria.categoria }}</option>
                                {% endfor %}
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-secondary btn-sm add-categoria" type="button"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <span class="span-invalido categoria-feed"></span>  
                    </div>    
                    <div class="form-group">
                        <label for="modalidade">Modalidade</label>
                        <textarea class="form-control form-control-sm" id="modalidade" placeholder="Modalidade">{% if modalidade.modalidade is defined %}{{ modalidade.modalidade }}{% endif %}</textarea>
                        <div class="invalid-feedback">Por favor, informe a modalidade.</div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="duracao">Duração em horas</label>
                                <div class="input-group date" id="datetimepicker3" data-target-input="nearest">
                                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="duracao" data-target="#datetimepicker3" value="{% if modalidade.duracao is defined %}{{ modalidade.duracao }}{% endif %}"/>
                                    <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                        <div class="input-group-text bg-secondary text-white border-0"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <span class="span-invalido duracao-feed"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="limite">Limite em horas</label>
                                <div class="input-group date" id="datetimepicker4" data-target-input="nearest">
                                    <input type="text" class="form-control form-control-sm datetimepicker-input" id="limite" data-target="#datetimepicker4" value="{% if modalidade.limite is defined %}{{ modalidade.limite }}{% endif %}"/>
                                    <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                        <div class="input-group-text bg-secondary text-white border-0"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <span class="span-invalido limite-feed"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group comprovante-feedback">
                        <label for="comprovante_id">Comprovante</label>
                        <div class="input-group">
                            <select id="comprovante_id">
                                <option></option>
                                {% for comprovante in comprovantes %}
                                <option value="{{ comprovante.comprovante_id }}"{% if comprovante.comprovante_id == modalidade.comprovante_id %} selected="selected"{% endif %}>{{ comprovante.comprovante }}</option>
                                {% endfor %}
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-secondary btn-sm add-comprovante" type="button"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>   
                        <span class="span-invalido comprovante-feed"></span> 
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

<!-- Modal -->
<div class="modal fade" id="adicionar-categoria" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario-adicionar-categoria-extra">
                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <input type="text" class="form-control form-control-sm" id="categoria" name="categoria" placeholder="Informe a categoria">
                        <div class="invalid-feedback">Por favor, informe a categoria.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary btn-sm" id="btn-salvar-extra-categoria"><i class="fas fa-save"></i> Salvar</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-undo"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="adicionar-comprovante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar comprovante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formulario-adicionar-comprovante-extra">
                    <div class="form-group">
                        <label for="comprovante">Comprovante</label>
                        <input type="text" class="form-control form-control-sm" id="comprovante" name="comprovante" autofocus placeholder="Informe o comprovante">
                        <div class="invalid-feedback">Por favor, informe o comprovante.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary btn-sm" id="btn-salvar-extra-comprovante"><i class="fas fa-save"></i> Salvar</button>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-undo"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
{% endblock %}

{% block scripts %}
{{ parent() }}
<script src="{{ constant('BASE_URL') }}assets/app/modalidade.js"></script>
<script src="{{ constant('BASE_URL') }}assets/app/comum.js"></script>
{% endblock %}
