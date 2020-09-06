<?php

namespace Alura\Cursos\Helper;

trait FlashMensagem
{
    public function defineMensagem(string $tipo, string $mensagem): void
    {
        $_SESSION['tipo_mensagem'] = $tipo;
        $_SESSION['mensagem'] = $mensagem;
    }
}