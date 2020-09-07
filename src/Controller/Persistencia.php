<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMensagem;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Persistencia implements RequestHandlerInterface
{
    use FlashMensagem;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryString = $request->getQueryParams();

        $id = filter_var($queryString['id'], FILTER_VALIDATE_INT);

        $parsedBody = $request->getParsedBody();

        $descricao = filter_var($parsedBody['descricao'], FILTER_SANITIZE_STRING);

        $curso = new Curso();
        $curso->setDescricao($descricao);

        $tipo_mensagem = 'success';
        if ( ! is_null($id) && $id !== false) {
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $this->defineMensagem($tipo_mensagem, 'Curso atualizado com sucesso');
        } else {
            $this->entityManager->persist($curso);
            $this->defineMensagem($tipo_mensagem, 'Curso adicionado com sucesso');
        }

        $this->entityManager->flush();

        return new Response(302, ['Location' => '/listar-cursos']);
    }
}
