<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ConfiguracaoBanparaLocalModel extends Model
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Ima\ConfiguracaoBanparaLocal::class);
    }

    public function removeConfiguracaoBanparaLocal(Ima\ConfiguracaoBanparaLocal $local)
    {
        $configuracaoBanparaLocal = $this->repository->find([
            'codEmpresa'      => $local->getCodEmpresa(),
            'codLocal'        => $local->getCodLocal(),
            'timestamp'       => $local->getTimestamp(),
            'numOrgaoBanpara' => $local->getNumOrgaoBanpara()
        ]);
        $this->remove($configuracaoBanparaLocal);
    }

    public function createConfiguracaoBanparaLocal($codEmpresa, $local, $timestamp, $numOrgaoBanpara)
    {
        $localizacaoConfiguracaoBanparaLocal = new Ima\ConfiguracaoBanparaLocal();
        $localizacaoConfiguracaoBanparaLocal->setCodEmpresa($codEmpresa);
        $localizacaoConfiguracaoBanparaLocal->setCodLocal($local->getCodLocal());
        $localizacaoConfiguracaoBanparaLocal->setTimestamp($timestamp);
        $localizacaoConfiguracaoBanparaLocal->setNumOrgaoBanpara($numOrgaoBanpara);

        $this->save($localizacaoConfiguracaoBanparaLocal);

        return $localizacaoConfiguracaoBanparaLocal;
    }
}
