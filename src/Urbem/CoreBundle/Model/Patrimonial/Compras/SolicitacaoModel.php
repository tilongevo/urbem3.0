<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\SolicitacaoRepository;

class SolicitacaoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var SolicitacaoRepository */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

        /** @var SolicitacaoRepository repository */
        $this->repository = $this->entityManager->getRepository(Solicitacao::class);
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
        $mapaItemRepository = $this->entityManager->getRepository("CoreBundle:Compras\\MapaItem");
        $resAu = $mapaItemRepository->findOneByCodSolicitacao($object->getCodSolicitacao());

        return is_null($resAu);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return mixed
     */
    public function getProximoCodSolicitacao($exercicio, $codEntidade)
    {
        return $this->repository->getProximoCodSolicitacao($exercicio, $codEntidade);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codModulo
     * @return null|object
     */
    public function getDataFixaSolicitacao($exercicio, $codEntidade, $codModulo)
    {
        $recuperaDataContabil = $this->entityManager->getRepository('CoreBundle:Administracao\ConfiguracaoEntidade')->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'codModulo' => $codModulo,
            'parametro' => 'data_fixa_solicitacao_compra'
        ]);

        return $recuperaDataContabil;
    }

    public function getAssinaturasSwCgm($exercicio, $codEntidade, $codModulo)
    {
        $recuperaDataContabil = $this->entityManager->getRepository('CoreBundle:Administracao\ConfiguracaoEntidade')->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'codModulo' => $codModulo,
            'parametro' => 'data_fixa_solicitacao_compra'
        ]);

        return $recuperaDataContabil;
    }

    public function getSolicitacoesComEntidade($exercicio)
    {
        $solicitacoes = $this->repository->getSolicitacoesComEntidade($exercicio);
        return $solicitacoes->getQuery()->getResult();
    }

    public function findOneByCodSolicitacao($codSolicitacao)
    {
        return $this->repository->findOneByCodSolicitacao($codSolicitacao);
    }

    public function getSolicitacoesMapaCompra($entidade, $exercicio, $preco)
    {
        return $this->repository->getSolicitacoesMapaCompra($entidade, $exercicio, $preco);
    }

    public function insertIntoSolicitacaoDotacao($cod_solicitacao, $cod_despesa, $exercicio)
    {
        return $this->repository->insertIntoSolicitacaoDotacao($cod_solicitacao, $cod_despesa, $exercicio);
    }

    public function montaincluiReservaSaldo($cod_reserva, $exercicio, $cod_despesa, $dt_validade_inicial, $dt_validade_final, $vl_reserva, $tipo, $motivo)
    {
        return $this->repository->montaincluiReservaSaldo($cod_reserva, $exercicio, $cod_despesa, $dt_validade_inicial, $dt_validade_final, $vl_reserva, $tipo, $motivo);
    }

    public function getProximaCodReservaSaldo()
    {
        return $this->repository->getProximaCodReservaSaldo();
    }

    public function getPatrimonioSolicitacaoDotacao($exercicio, $cod_solicitacao)
    {
        return $this->repository->getPatrimonioSolicitacaoDotacao($exercicio, $cod_solicitacao);
    }

    public function getSolicitacaoNotHomologadoAndNotAnulada($exercicio, $cod_solicitacao)
    {
        return $this->repository->getSolicitacaoNotHomologadoAndNotAnulada($exercicio, $cod_solicitacao);
    }

    public function montaRecuperaPermissaoAnularHomologacao($cod_solicitcao, $cod_entidade, $exericio)
    {
        return $this->repository->montaRecuperaPermissaoAnularHomologacao($cod_solicitcao, $cod_entidade, $exericio);
    }

    public function montaRecuperaTodosNomEntidade($exercicio, $cod_entidade, $cod_solicitacao)
    {
        return $this->repository->montaRecuperaTodosNomEntidade($exercicio, $cod_entidade, $cod_solicitacao);
    }

    /**
     * @param $codCompraDireta
     * @param $codModalidade
     * @param $codEntidade
     * @param $exercicioEntidade
     * @return mixed
     */
    public function montaRecuperaSolicitacaoAgrupadaNaoAnulada($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade)
    {
        return $this->repository->montaRecuperaSolicitacaoAgrupadaNaoAnulada($codCompraDireta, $codModalidade, $codEntidade, $exercicioEntidade);
    }

    /**
     * @param $codEntidade
     * @param $codSolicitacao
     * @param $exercicio
     * @return mixed
     */
    public function recuperaRelacionamentoItemHomologacao($codEntidade, $codSolicitacao, $exercicio)
    {
        return $this->repository->recuperaRelacionamentoItemHomologacao($codEntidade, $codSolicitacao, $exercicio);
    }

    /**
     * @param $codSolicitacao
     * @param $codEntidade
     * @param $exercicio
     * @return mixed
     */
    public function montaRecuperaItensConsulta($codSolicitacao, $codEntidade, $exercicio)
    {
        return $this->repository->montaRecuperaItensConsulta($codSolicitacao, $codEntidade, $exercicio);
    }

    /**
     * @param      $exercicio
     * @param null $codEntidade
     * @param bool $codSolicitacaoPai
     *
     * @return ORM\QueryBuilder
     */
    public function montaRecuperaRelacionamentoSolicitacaoQuery($exercicio, $codEntidade = null, $codSolicitacaoPai = false)
    {
        $queryBuilder = $this->repository->createQueryBuilder('s');
        $queryBuilder
            ->join('s.fkComprasSolicitacaoItens', 'si')
            ->join('s.fkOrcamentoEntidade', 'e')
            ->innerJoin('s.fkSwCgm', 'sc')
            ->where('s.exercicio = :exercicio')
            ->setParameter('exercicio', $exercicio)
        ;

        if (!is_null($codEntidade)) {
            $queryBuilder
                ->andWhere('s.codEntidade = :codEntidade')
                ->setParameter('codEntidade', $codEntidade);
        }

        if (false != $codSolicitacaoPai) {
            $queryBuilder->andWhere("s.codSolicitacao NOT IN ($codSolicitacaoPai)");
        }

        return $queryBuilder;
    }

    /**
     * @param      $exercicio
     * @param null $codEntidade
     * @param bool $codSolicitacaoPai
     *
     * @return array
     */
    public function montaRecuperaRelacionamentoSolicitacao($exercicio, $codEntidade = null, $codSolicitacaoPai = false)
    {
        return $this->montaRecuperaRelacionamentoSolicitacaoQuery($exercicio, $codEntidade, $codSolicitacaoPai)->getQuery()->getResult();
    }

    /**
     * @param $codSolicitacao
     * @param $codEntidade
     * @param $exercicio
     * @return mixed
     */
    public function montaRecuperaItemSolicitacao($codSolicitacao, $codEntidade, $exercicio)
    {
        return $this->repository->montaRecuperaItemSolicitacao($codSolicitacao, $codEntidade, $exercicio);
    }


    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codSolicitacao
     * @return mixed
     */
    public function recuperaSolicitacaoItensAnulacao($exercicio, $codEntidade, $codSolicitacao)
    {
        return $this->repository->recuperaSolicitacaoItensAnulacao($codSolicitacao, $codEntidade, $exercicio);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getItensDescricao($request)
    {
        return $this->repository->getItensDescricao($request);
    }
}
