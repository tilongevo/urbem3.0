<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 27/07/16
 * Time: 15:40
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Repository\Patrimonio\Licitacao\LicitacaoRepository;

/**
 * Class LicitacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class LicitacaoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var LicitacaoRepository|null */
    protected $repository = null;

    /**
     * LicitacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\Licitacao");
    }

    /**
     * @param $filtros
     * @return mixed
     */
    public function getLicitacaoByFiltros($filtros)
    {
        return $this->repository->getLicitacaoByFiltros($filtros);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return mixed
     */
    public function getRecuperaTodos($codMapa, $exercicio)
    {
        return $this->repository->getRecuperaTodos($codMapa, $exercicio);
    }

    /**
     * @param bool $cod_licitacao
     * @param bool $cod_modalidade
     * @param bool $cod_entidade
     * @param bool $num_edital
     * @param bool $exercicio
     * @return mixed
     */
    public function montaRecuperaEditalSuspender(
        $codLicitacao = false,
        $codModalidade = false,
        $codEntidade = false,
        $numEdital = false,
        $exercicio = false
    ) {
        return $this->repository->montaRecuperaEditalSuspender(
            $codLicitacao,
            $codModalidade,
            $codEntidade,
            $numEdital,
            $exercicio
        );
    }

    /**
     * @param int $codLicitacao
     * @param int $codModalidade
     * @param int $codEntidade
     * @param string $exercicio
     * @return Licitacao
     */
    public function getOneLicitacao($codLicitacao, $codModalidade, $codEntidade, $exercicio)
    {
        return $this->repository->findOneBy([
            'codLicitacao' => $codLicitacao,
            'codModalidade' => $codModalidade,
            'codEntidade' => $codEntidade,
            'exercicio' => $exercicio
        ]);
    }

    /**
     * @param string $exercicio
     * @param ProxyQuery|ORM\QueryBuilder $proxyQuery
     * @return ProxyQuery
     */
    public function getLicitacaoManutencaoPropostas(ProxyQuery $proxyQuery, $exercicio)
    {
        $licitacoes = $this->repository->getLicitacaoManutencaoPropostas($exercicio);
        $aliases = $proxyQuery->getRootAliases();

        $ids = [];
        foreach ($licitacoes as $licitacaoesId) {
            $ids[] = $licitacaoesId->codlicitacao;
        }

        $licitacoes = $ids;
        $licitacoes = (empty($licitacoes) ? 0 : $licitacoes);
        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in("{$aliases[0]}.codLicitacao", $licitacoes)
            );

        return $proxyQuery;
    }

    /**
     * @param $codLicitacao
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicio
     * @param bool|false $numEdital
     * @return object
     */
    public function montaRecuperaParticipanteLicitacaoManutencaoPropostas(
        $codLicitacao,
        $codModalidade,
        $codEntidade,
        $exercicio,
        $numEdital = false
    ) {
        $numEdital = false;
        return $this->repository->montaRecuperaParticipanteLicitacaoManutencaoPropostas(
            $codLicitacao,
            $codModalidade,
            $codEntidade,
            $exercicio,
            $numEdital
        );
    }

    /**
     * Pega a listagem de Autorizações do Empenho Disponíveis
     *
     * @param ProxyQueryInterface|ProxyQuery|ORM\QueryBuilder $proxyQuery
     * @param string $exercicio
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function getAutorizacoesEmpenhoDisponiveis($proxyQuery, $exercicio)
    {
        $arrCodLicitacoes = $this->repository->findAutorizacoesEmpenhoDisponiveis($exercicio);
        $codLicitacoes = [];
        foreach ($arrCodLicitacoes as $licitacao) {
            $codLicitacoes[] = $licitacao['cod_licitacao'];
        }
        $codLicitacoes = (empty($codLicitacoes)) ? 0 : $codLicitacoes;

        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in("{$proxyQuery->getRootAliases()[0]}.codLicitacao", $codLicitacoes)
            )
            ->andWhere("{$proxyQuery->getRootAliases()[0]}.exercicio = '{$exercicio}'");

        return $proxyQuery;
    }

    /**
     * Pega a listagem dos Grupos de Autorizações do Empenho
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade']
     * @return array $result
     */
    public function recuperaGrupoAutEmpenho($params)
    {
        return $this->repository->montaRecuperaGrupoAutEmpenho($params);
    }

    /**
     * Pega a listagem de Itens dos Grupos de Autorizações do Empenho
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade', 'cgmFornecedor',
     *                      'codDespesa', 'codConta']
     * @return array $result
     */
    public function recuperaItensAgrupadosSolicitacaoLicitacao($params)
    {
        return $this->repository->montaRecuperaItensAgrupadosSolicitacaoLicitacao($params);
    }

    /**
     * Pega a listagem de Itens dos Grupos de Autorizações do Empenho por Mapa
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade', 'cgmFornecedor',
     *                      'codDespesa', 'codConta']
     * @return array $result
     */
    public function recuperaItensAgrupadosSolicitacaoLicitacaoMapa($params)
    {
        return $this->repository->montaRecuperaItensAgrupadosSolicitacaoLicitacaoMapa($params);
    }

    /**
     * Pega a listagem de Itens dos Grupos de Autorizações do Empenho 'Imp'
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade', 'cgmFornecedor',
     *                      'codDespesa', 'codConta']
     * @return array $result
     */
    public function recuperaItensAgrupadosSolicitacaoLicitacaoImp($params)
    {
        return $this->repository->montaRecuperaItensAgrupadosSolicitacaoLicitacaoImp($params);
    }

    /**
     * Pega a listagem de Licitacoes não Anuladas
     *
     * @param array $params ['codLicitacao', 'exercicio', 'codEntidade', 'codModalidade']
     * @return array $result
     */
    public function recuperaSolicitacaoLicitacaoNaoAnulada($params)
    {
        return $this->repository->montaRecuperaSolicitacaoLicitacaoNaoAnulada($params);
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @return ProxyQuery
     */
    public function listForJulgamentoPropostaQuery(ProxyQuery $proxyQuery)
    {
        $primRes = $this->repository->getLicitacaoJulgamentoProposta();
        $alias = $proxyQuery->getRootAlias();

        $codigos = [];

        if (count($primRes) > 0) {
            foreach ($primRes as $res) {
                $codigos[] = $res['cod_licitacao'];
            }
        } else {
            $codigos[] = 0;
        }

        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in(sprintf('%s.codLicitacao', $alias), $codigos)
            );

        return $proxyQuery;
    }

    /**
     * @param $q
     * @return ORM\QueryBuilder
     */
    public function carregaLicitacaoQuery($q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('licitacao');

        $concat = $queryBuilder->expr()->concat($queryBuilder->expr()->literal(''), 'licitacao.codLicitacao');
        $concat = $queryBuilder->expr()->concat($concat, $queryBuilder->expr()->concat($queryBuilder->expr()->literal('/'), 'licitacao.exercicio'));

        $queryBuilder->add('where', $queryBuilder->expr()->like($concat, $queryBuilder->expr()->literal(sprintf('%%%s%%', $q))));

        return $queryBuilder;
    }
    
    /**
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicio
     * @return array
     */
    public function carregaLicitacaoContrato($codModalidade, $codEntidade, $exercicio)
    {
        return $this->repository->carregaLicitacaoContrato($codModalidade, $codEntidade, $exercicio);
    }

    /**
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicio
     * @return int
     */
    public function getNextCodLicitacao($codModalidade, $codEntidade, $exercicio)
    {
        return $this->repository->getNextCodLicitacao($codModalidade, $codEntidade, $exercicio);
    }

    /**
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicio
     * @return array
     */
    public function carregaLicitacaoEdital($codModalidade, $codEntidade, $exercicio)
    {
        return $this->repository->carregaLicitacaoEdital($codModalidade, $codEntidade, $exercicio);
    }
}
