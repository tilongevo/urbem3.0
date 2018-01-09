<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\TranslatorInterface;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoGerado;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoGeradoExcluido;

class AssentamentoGeradoExcluidoModel extends AbstractModel
{
    /** @var EntityManager  */
    protected $em = null;

    protected $entity = null;

    /**
     * AssentamentoGeradoExcluidoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository('CoreBundle:Pessoal\AssentamentoGeradoExcluido');
    }

    /**
     * @param AssentamentoGerado $assentamentoGerado
     * @param TranslatorInterface $translator
     */
    public function excluirAssentamentoGerado(AssentamentoGerado $assentamentoGerado, TranslatorInterface $translator)
    {
        /** @var AssentamentoGeradoExcluido $asssentamentoExclui */
        $asssentamentoExcluido = new AssentamentoGeradoExcluido();
        $asssentamentoExcluido
            ->setFkPessoalAssentamentoGerado($assentamentoGerado)
            ->setDescricao($translator->trans('label.ferias.assentamento.assentamentoGerado.exclusao'));

        $this->em->persist($asssentamentoExcluido);
    }
}
