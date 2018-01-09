<?php

namespace Urbem\CoreBundle\Model\Ima;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Repository;
use Symfony\Component\Validator\Validator;

class ConfiguracaoBanparaOrgaoModel extends Model
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Ima\ConfiguracaoBanparaOrgao::class);
    }

    public function removeConfiguracaoBanparaOrgao(Ima\ConfiguracaoBanparaOrgao $orgao)
    {
        $configuracaoBanparaOrgao = $this->repository->find([
            'codEmpresa'      => $orgao->getCodEmpresa(),
            'codOrgao'        => $orgao->getCodOrgao(),
            'timestamp'       => $orgao->getTimestamp(),
            'numOrgaoBanpara' => $orgao->getNumOrgaoBanpara()
        ]);
        $this->remove($configuracaoBanparaOrgao);
    }

    public function createConfiguracaoBanparaOrgao($codEmpresa, $orgao, $timestamp, $numOrgaoBanpara)
    {
        $localizacaoConfiguracaoBanparaOrgao = new Ima\ConfiguracaoBanparaOrgao();
        $localizacaoConfiguracaoBanparaOrgao->setCodEmpresa($codEmpresa);
        $localizacaoConfiguracaoBanparaOrgao->setCodOrgao($orgao);
        $localizacaoConfiguracaoBanparaOrgao->setTimestamp($timestamp);
        $localizacaoConfiguracaoBanparaOrgao->setNumOrgaoBanpara($numOrgaoBanpara);

        $this->save($localizacaoConfiguracaoBanparaOrgao);

        return $localizacaoConfiguracaoBanparaOrgao;
    }
}
