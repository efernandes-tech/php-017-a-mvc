<?php

use Alura\Cursos\Controller\{
    Deslogar,
    Exclusao,
    FormularioEdicao,
    ListarCursos,
    Persistencia,
    FormularioInsercao,
    FormularioLogin,
    RealizarLogin
};

return [
    '/listar-cursos' => ListarCursos::class,
    '/novo-curso' => FormularioInsercao::class,
    '/salvar-curso' => Persistencia::class,
    '/excluir-curso' => Exclusao::class,
    '/alterar-curso' => FormularioEdicao::class,
    '/login' => FormularioLogin::class,
    '/realizar-login' => RealizarLogin::class,
    '/logout' => Deslogar::class,
];
