<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao;

/**
 * Class RequisicaoAnulacaoModel
 */
class RequisicaoAnulacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * RequisicaoAnulacaoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository(RequisicaoAnulacao::class);
    }

    /**
     * @param Requisicao $requisicao
     */
    public function removeAll(Requisicao $requisicao)
    {
        /** @var RequisicaoAnulacao $requisicaoAnulacao */
        foreach ($requisicao->getFkAlmoxarifadoRequisicaoAnulacoes() as $requisicaoAnulacao) {
            $this->remove($requisicaoAnulacao);
        }
    }

    /**
     * @param Requisicao $requisicao
     * @param string     $motivo
     * @return RequisicaoAnulacao
     */
    public function anularRequisicao(Requisicao $requisicao, $motivo)
    {
        $requisicaoAnulacao = new RequisicaoAnulacao();
        $requisicaoAnulacao->setFkAlmoxarifadoRequisicao($requisicao);
        $requisicaoAnulacao->setMotivo($motivo);

        $this->save($requisicaoAnulacao);

        return $requisicaoAnulacao;
    }

    public function encaminhar(SwProcesso $processo, SwSituacaoProcesso $situacao, $usuario, Orgao $orgao)
    {
        $swAndamento = new SwAndamento();
        $swAndamento->setCodProcesso($processo->getCodProcesso());
        $swAndamento->setAnoExercicio($processo->getAnoExercicio());
        $swAndamento->setCodUsuario($usuario);
        $swAndamento->setCodSituacao($situacao);
        $swAndamento->setCodOrgao($orgao);

        $this->save($swAndamento);

        $processo->setCodSituacao($situacao);
        $this->save($processo);
    }
}
