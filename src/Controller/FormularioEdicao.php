<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMensagem;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;
use Alura\Cursos\Helper\RenderizadorDeHtml;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormularioEdicao implements RequestHandlerInterface
{
    use RenderizadorDeHtml, FlashMensagem;

    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $repositorioCursos;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioCursos = $entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryString = $request->getQueryParams();

        $id = filter_var($queryString['id'], FILTER_VALIDATE_INT);

        if (is_null($id) || $id === false) {
            $this->defineMensagem('danger', 'Curso não encontrado');

            return new Response(302, ['Location' => '/listar-cursos']);
        }

        $curso = $this->repositorioCursos->find($id);

        $html = $this->renderizaHtml('cursos/formulario.php', [
            'curso' => $curso,
            'titulo' => 'Alterar Curso ' . $curso->getDescricao()
        ]);

        return new Response(200, [], $html);
    }
}