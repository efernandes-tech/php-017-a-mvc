<?php

namespace Alura\Cursos\Controller;

use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Alura\Cursos\Helper\RenderizadorDeHtml;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class FormularioLogin implements RequestHandlerInterface
{
    use RenderizadorDeHtml;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->renderizaHtml('login/formulario.php', [
            'titulo' => 'Login'
        ]);

        return new Response(200, [], $html);
    }
}