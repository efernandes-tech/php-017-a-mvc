<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Usuario;
use Alura\Cursos\Helper\FlashMensagem;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RealizarLogin implements RequestHandlerInterface
{
    use FlashMensagem;

    private $repositorioDeUsuarios;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeUsuarios = $entityManager->getRepository(usuario::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $parsedBody = $request->getParsedBody();

        $email = filter_var($parsedBody['email'], FILTER_VALIDATE_EMAIL);

        if (is_null($email) || $email === false) {
            $this->defineMensagem('danger', 'E-mail inválido');

            return new Response(302, ['Location' => '/login']);
        }

        $senha = filter_var($parsedBody['senha'], FILTER_SANITIZE_STRING);

        $usuario = $this->repositorioDeUsuarios->findOneBy(['email' => $email]);

        if (is_null($usuario) || ! $usuario->senhaEstaCorreta($senha)) {
            $this->defineMensagem('danger', 'E-mail e senha inválidos');

            return new Response(302, ['Location' => '/login']);
        }

        $_SESSION['logado'] = true;

        return new Response(302, ['Location' => '/listar-cursos']);
    }
}
