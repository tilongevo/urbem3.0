<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\Pensao;
use Urbem\CoreBundle\Entity\Pessoal\ResponsavelLegal;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;

class ResponsavelLegalModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * PensionistaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Pessoal\ResponsavelLegal');
    }

    /**
     * @param Pensao $pensao
     * @param SwCgmPessoaFisica $cgmPessoaFisica
     * @return ResponsavelLegal
     */
    public function saveResponsavelLegal(Pensao $pensao, SwCgmPessoaFisica $cgmPessoaFisica)
    {
        $responsavelLegal = new ResponsavelLegal();
        $responsavelLegal
            ->setFkPessoalPensao($pensao)
            ->setFkSwCgmPessoaFisica($cgmPessoaFisica);

        $this->save($responsavelLegal);

        return $responsavelLegal;
    }
}
