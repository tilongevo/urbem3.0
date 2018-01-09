<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Entity\Frota\Manutencao;
use Urbem\CoreBundle\Entity\Frota\Veiculo;
use Urbem\CoreBundle\Model\Folhapagamento\BasesModel;
use Urbem\CoreBundle\Model\InterfaceModel;
use Urbem\CoreBundle\Repository\Patrimonio\Frota\ManutencaoRepository;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;

class ManutencaoModel extends BasesModel implements InterfaceModel
{
    protected $entityManager = null;

    /** @var ManutencaoRepository $repository */
    protected $repository = null;

    /**
     * ManutencaoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Frota\Manutencao::class);
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * Pega o próximo identificador disponível
     *
     * @author Helike Long (helikelong@gmail.com)
     * @date   2016-10-21
     *
     * @param  string $complemento
     * @return int identifier
     */
    public function getAvailableIdentifier($complemento = '')
    {
        return $this->repository->getAvailableIdentifier($complemento);
    }


    /**
     * @param Almoxarifado\LancamentoRequisicao $lancamentoRequisicao
     * @param Frota\Veiculo $veiculo
     * @param $exercicio
     * @param $km
     * @param $observacao
     * @return Frota\Manutencao
     */
    public function buildManutencaoByRequisicaoItem(Almoxarifado\LancamentoRequisicao $lancamentoRequisicao, Frota\Veiculo $veiculo, $exercicio, $km, $observacao)
    {
        $manutencao = $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codVeiculo' => $veiculo,
        ]);

        if (is_null($manutencao)) {
            $manutencao = new Frota\Manutencao();
            $manutencao->setExercicio($exercicio);
            $manutencao->setCodManutencao($this->getAvailableIdentifier());
            $manutencao->setCodVeiculo($veiculo);
            $manutencao->setDtManutencao(new \DateTime());
            $manutencao->setKm($km);
            $manutencao->setObservacao($observacao);

            $manutencaoItemModel = new ManutencaoItemModel($this->entityManager);
            $manutencaoItemModel->buildManutencaoItemByManutencao($manutencao, $lancamentoRequisicao);

            $this->entityManager->persist($manutencao);
            $this->entityManager->flush();
        }

        return $manutencao;
    }

    /**
     * @param Veiculo $veiculo
     * @param string $exercicio
     * @param string $km
     * @param string $observacao
     * @return null|Manutencao
     */
    public function buildManutencao(Veiculo $veiculo, $exercicio, $km, $observacao)
    {
        $codManutencao = $this->repository->getNextCodManutencao($exercicio);

        $manutencao = new Manutencao();

        $manutencao->setCodManutencao($codManutencao);
        $manutencao->setFkFrotaVeiculo($veiculo);

        $manutencao->setExercicio($exercicio);
        $manutencao->setDtManutencao(new \DateTime());
        $manutencao->setKm($km);
        $manutencao->setObservacao($observacao);

        return $manutencao;
    }


    /**
     * Retorna a ProxyQuery com os itens da Manutenção para listagem
     *
     * @param ProxyQuery $proxyQuery
     * @return ProxyQuery
     */
    public function getManutencaoList(ProxyQuery $proxyQuery, $exercicio)
    {
        $queryManutencaoAnulacao = $this->entityManager->createQueryBuilder();
        $queryManutencaoAnulacao
            ->select('1')
            ->from(Frota\ManutencaoAnulacao::class, 'ma')
            ->where('ma.codManutencao = o.codManutencao')
            ->andWhere('ma.exercicio = o.exercicio');

        $proxyQuery
            ->andWhere('o.exercicio = :exercicio')
            ->andWhere(
                $proxyQuery->expr()->not($proxyQuery->expr()->exists($queryManutencaoAnulacao->getDQL()))
            )
            ->setParameters([
                'exercicio' => $exercicio,
            ]);

        return $proxyQuery;
    }
}
