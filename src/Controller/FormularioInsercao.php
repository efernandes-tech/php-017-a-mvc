<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Helper\RenderizadorDeHtml;

class FormularioInsercao implements InterfaceControladorRequisicao
{
    use RenderizadorDeHtml;

    public function processaRequisicao(): void
    {
        echo $this->renderizaHtml('cursos/formulario.php', [
            'titulo' => 'Novo Curso'
        ]);
    }
}