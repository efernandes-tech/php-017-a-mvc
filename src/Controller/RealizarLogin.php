<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Entity\Usuario;

class RealizarLogin implements InterfaceControladorRequisicao
{
    private $repositorioDeUsuarios;

    public function __construct()
    {
        $entityManager = (new EntityManagerCreator())->getEntityManager();

        $this->repositorioDeUsuarios = $entityManager->getRepository(usuario::class);
    }

    public function processaRequisicao(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

        if (is_null($email) && $email === false) {
            echo 'E-mail inválido';
            return;
        }

        $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

        $usuario = $this->repositorioDeUsuarios->findOneBy(['email' => $email]);

        if (is_null($usuario) || ! $usuario->senhaEstaCorreta($senha)) {
            echo 'E-mail e senha inválidos';
            return;
        }

        header('Location: /listar-cursos', true, 302);
    }
}