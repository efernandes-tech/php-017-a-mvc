<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Entity\Curso;
use Alura\Cursos\Helper\FlashMensagem;
use Alura\Cursos\Infra\EntityManagerCreator;

class Persistencia implements InterfaceControladorRequisicao
{
    use FlashMensagem;

    private $entityManager;

    public function __construct()
    {
        $this->entityManager = (new EntityManagerCreator())->getEntityManager();
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);

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

        header('Location: /listar-cursos', true, 302);
    }
}
