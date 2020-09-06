<?php

namespace Alura\Cursos\Controller;

use Alura\Cursos\Infra\EntityManagerCreator;
use Alura\Cursos\Entity\Curso;

class Persistencia implements InterfaceControladorRequisicao
{
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

        if ( ! is_null($id) && $id !== false) {
            $curso->setId($id);
            $this->entityManager->merge($curso);
            $_SESSION['tipo_mensagem'] = 'Curso atualizado com sucesso';
        } else {
            $this->entityManager->persist($curso);
            $_SESSION['tipo_mensagem'] = 'Curso adicionado com sucesso';
        }
        $_SESSION['tipo_mensagem'] = 'success';

        $this->entityManager->flush();

        header('Location: /listar-cursos', true, 302);
    }
}
