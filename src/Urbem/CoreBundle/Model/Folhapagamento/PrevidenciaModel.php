<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Previdencia;
use Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia;

class PrevidenciaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Previdencia::class);
    }

    public function canRemove($object)
    {
        $checkPrevidencia = $this->entityManager->getRepository(PrevidenciaPrevidencia::class);
        $res = $checkPrevidencia->findOneByCodPrevidencia($object->getCodPrevidencia());

        return is_null($res);
    }

    /**
     * Retorna a lista de previdencia para quando nao existe contrato para o servidor.
     * @param bool $sonata
     * @return array
     */
    public function getPrevidenciaChoices($sonata = false)
    {
        $previdencias = $this->repository->getPrevidencias();

        $options = [];

        foreach ($previdencias as $previdencia) {
            if ($sonata) {
                $options[$previdencia->cod_previdencia . " - " . $previdencia->descricao] = $previdencia->cod_previdencia;
            } else {
                $options[$previdencia->cod_previdencia] = $previdencia->cod_previdencia . " - " . $previdencia->descricao;
            }
        }

        return $options;
    }

    /**
     * @param bool $stFiltro
     *
     * @return array
     */
    public function getPrevidenciaRat($stFiltro = false)
    {
        return $this->repository->getPrevidenciaRat($stFiltro);
    }

    /**
     * @param bool $stFiltro
     *
     * @return array
     */
    public function getPrevidenciaPrevidencia($stFiltro = false)
    {
        return $this->repository->getPrevidenciaPrevidencia($stFiltro);
    }
}
