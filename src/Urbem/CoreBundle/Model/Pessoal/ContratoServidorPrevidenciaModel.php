<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ContratoServidorPrevidenciaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\ContratoServidorPrevidencia");
    }

    public function getListaPrevidencia()
    {
        $lista = $this->repository->getListaPrevidencia();
        $previdencias = array();


        foreach ($lista as $result_key) {
            $previdencias[$result_key->descricao . " - " . $result_key->cod_previdencia] = $result_key->cod_previdencia;
        }

        return $previdencias;
    }

    public function getListaPrevidenciaSelecionados($cod_contrato)
    {
        $lista = $this->repository->getListaPrevidenciaSelecionados($cod_contrato);
        $previdencias = array();

        foreach ($lista as $result_key) {
            $previdencias[$result_key->descricao . " - " . $result_key->cod_previdencia] = $result_key->cod_previdencia;
        }

        return $previdencias;
    }

    public function deleteContratoServidorPrevidencia($cod_contrato)
    {
        return $this->repository->deleteContratoServidorPrevidencia($cod_contrato);
    }

    /**
     * @param bool $filtro
     *
     * @return mixed
     */
    public function recuperaRelacionamento($filtro = false)
    {
        return $this->repository->recuperaRelacionamento($filtro);
    }

    /**
     * @param $codPrevidencia
     * @return mixed
     */
    public function getDadosRelatorioServidor($codPrevidencia)
    {
        return $this->repository->getDadosRelatorioServidor($codPrevidencia);
    }
}
