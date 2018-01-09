<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\ConfiguracaoIpeRepository;

class ConfiguracaoIpeModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ConfiguracaoIpeRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\ConfiguracaoIpe");
    }

    /**
     * @param $vigencia
     * @return mixed
     */
    public function getNextCodConfiguracao($vigencia)
    {
        return $this->repository->getNextCodConfiguracao($vigencia);
    }

    /**
     * @param $codConfiguracao
     * @param $vigencia
     * @return array
     */
    public function removeIpePensionista($codConfiguracao, $vigencia)
    {
        return $this->repository->removeIpePensionista($codConfiguracao, $vigencia);
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function montaExportarArquivoIpers($params)
    {
        return $this->repository->montaExportarArquivoIpers($params);
    }

    /**
     * @param $params
     *
     * @return array
     */
    public function montaRecuperaTodosVigencia($params)
    {
        return $this->repository->montaRecuperaTodosVigencia($params);
    }
}
