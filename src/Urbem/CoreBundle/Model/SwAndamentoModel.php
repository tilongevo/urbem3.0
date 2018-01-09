<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\SwAndamento;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwSituacaoProcesso;
use Urbem\CoreBundle\Model;

/**
 * Class SwAndamentoModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwAndamentoModel extends AbstractModel
{
    /** @var ORM\EntityRepository|\Urbem\CoreBundle\Repository\SwAndamentoRepository  */
    protected $repository;

    /**
     * SwAndamentoModel constructor.
     *
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SwAndamento::class);
    }

    /**
     * @param SwProcesso         $swProcesso
     * @param Orgao              $orgao
     * @param Usuario            $usuario
     * @param SwSituacaoProcesso $swSituacaoProcesso
     *
     * @return SwAndamento
     */
    public function buildOne(SwProcesso $swProcesso, Orgao $orgao, Usuario $usuario, SwSituacaoProcesso $swSituacaoProcesso)
    {
        $codAndamento = $this->repository
            ->nextCodAndamento($swProcesso->getCodProcesso(), $swProcesso->getAnoExercicio());

        $swAndamento = new SwAndamento();
        $swAndamento
            ->setCodAndamento($codAndamento)
            ->setFkSwProcesso($swProcesso)
            ->setFkOrganogramaOrgao($orgao)
            ->setFkAdministracaoUsuario($usuario)
            ->setFkSwSituacaoProcesso($swSituacaoProcesso);

        $this->entityManager->persist($swAndamento);

        return $swAndamento;
    }
}
