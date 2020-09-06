<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Alura\Cursos\Helper\RenderizadorDeHtml;
use Psr\Http\Message\ServerRequestInterface;

class FormularioInsercao implements InterfaceControladorRequisicao
{
    use RenderizadorDeHtml;

    public function processaRequisicao(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->renderizaHtml('cursos/formulario.php', [
            'titulo' => 'Novo Curso'
        ]);

        return new Response(200, [], $html);
    }
}