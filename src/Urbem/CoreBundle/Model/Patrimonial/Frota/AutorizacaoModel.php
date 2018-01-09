<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Frota;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Urbem\CoreBundle\Repository\Patrimonio\Frota\AutorizacaoRepository;
use Urbem\CoreBundle\Entity\Frota\Autorizacao;
use Urbem\CoreBundle\Model;

class AutorizacaoModel implements Model\InterfaceModel
{
    private $entityManager = null;

    /**
     * @var AutorizacaoRepository $repository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Autorizacao::class);
    }

    /**
     * Pega o próximo identificador disponível
     *
     * @param  string $exercicio
     * @return int $result identifier
     */
    public function getAvailableIdentifier($exercicio)
    {
        return $this->repository->getAvailableIdentifier($exercicio);
    }

    public function canRemove($object)
    {
        $efetivacaoModel = new Model\Patrimonial\Frota\EfetivacaoModel($this->entityManager);
        return empty($efetivacaoModel->getEfetivacaoInfo($object));
    }

    /**
     * Retorna a Autorização informada
     *
     * @param  array $params ['codAutorizacao', 'exercicio']
     * @return Autorizacao Autorizacao
     */
    public function getAutorizacaoInfo($params)
    {
        $autorizacao = $this->repository->findOneBy([
            'codAutorizacao' => $params['codAutorizacao'],
            'exercicio' => $params['exercicioAutorizacao']
        ]);

        return $autorizacao;
    }

    /**
     * @param ProxyQueryInterface $proxyQuery
     * @param string|null         $exercicio
     * @return ProxyQueryInterface
     */
    public function getAutorizacoesSaidaAbastecimento(ProxyQueryInterface $proxyQuery, $exercicio = null)
    {
        $autorizacoes = $this->repository->getAutorizacaoSaidaAbastecimento($exercicio);

        $ids = [];
        foreach ($autorizacoes as $autorizacao) {
            $ids[] = $autorizacao['cod_autorizacao'];
        }

        $ids = (true == empty($ids)) ? 0 : $ids;

        $rootAlias = $proxyQuery->getRootAlias();
        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in("{$rootAlias}.codAutorizacao", ":codigos")
            )
            ->setParameter(":codigos", $ids)
        ;

        if (false == is_null($exercicio)) {
            $proxyQuery
                ->andWhere("{$rootAlias}.exercicio = :exercicio")
                ->setParameter("exercicio", $exercicio);
        }

        return $proxyQuery;
    }

    /**
     * @param Autorizacao $autorizacao
     * @return array
     */
    public function getAutorizacaoSaidaAbastecimento(Autorizacao $autorizacao)
    {
        $result = $this->repository
            ->getAutorizacaoSaidaAbastecimento($autorizacao->getExercicio(), $autorizacao->getCodAutorizacao());

        return $result;
    }
}
