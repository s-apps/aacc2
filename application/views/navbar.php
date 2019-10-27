<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{ constant('BASE_URL') }}admin/dashboard"><i class="fas fa-home"></i></a>
        </li>
        {% if constant('USUARIO_NIVEL') == 0 %}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>Cadastros</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
                <a class="dropdown-item" href="{{ constant('BASE_URL') }}admin/categoria"><i class="fas fa-th-large"></i> Categorias</a>
                <a class="dropdown-item" href="{{ constant('BASE_URL') }}admin/comprovante"><i class="fas fa-certificate"></i> Comprovantes</a>
                <a class="dropdown-item" href="{{ constant('BASE_URL') }}admin/modalidade"><i class="fas fa-th"></i> Modalidades</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ constant('BASE_URL') }}admin/aluno"><i class="fas fa-graduation-cap"></i> Alunos</a>
                <a class="dropdown-item" href="{{ constant('BASE_URL') }}admin/curso"><i class="fas fa-university"></i> Cursos</a>
                <a class="dropdown-item" href="{{ constant('BASE_URL') }}admin/professor"><i class="fas fa-users"></i> Professores</a>
            </div>
        </li>
        {% endif %}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Lançamentos</a>
            <div class="dropdown-menu" aria-labelledby="dropdown02">
                <a class="dropdown-item" href="{{ constant('BASE_URL') }}atividade"><i class="fas fa-cubes"></i> Atividades</a>
            </div>
        </li>
        {% if constant('USUARIO_NIVEL') == 0 %}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Relatórios</a>
            <div class="dropdown-menu" aria-labelledby="dropdown02">
                <a class="dropdown-item" href="{{ constant('BASE_URL') }}admin/aluno/horas-realizadas-aluno"><i class="fas fa-clock"></i> Aluno - Horas Realizadas</a>
            </div>
        </li>
        {% endif %}
    </ul>
    <ul class="navbar-nav">
        <li class="nav-item">
            <span class="navbar-text">Olá {{ constant('USUARIO_NOME') ~  ' | ' }}</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ constant('BASE_URL') }}logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </li>
    </ul>
</div>