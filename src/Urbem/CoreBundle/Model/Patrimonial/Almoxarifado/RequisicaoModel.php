<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use InvalidArgumentException;
use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\Requisicao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoAnulacao;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoHomologada;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\RequisicaoItensAnulacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\RequisicaoRepository;

/**
 * Class RequisicaoModel
 */
class RequisicaoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var RequisicaoRepository|null $repository */
    protected $repository = null;

    /**
     * RequisicaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Requisicao::class);
    }

    /**
     * @param Requisicao $requisicao
     * @return bool
     */
    public function canRemove(Requisicao $requisicao)
    {
        $requisicaoHomologada = $requisicao->getFkAlmoxarifadoRequisicaoHomologadas()->filter(
            function (RequisicaoHomologada $requisicaoHomologada) {
                if (true == $requisicaoHomologada->getHomologada()) {
                    return $requisicaoHomologada;
                }
            }
        );

        $canRemove = $requisicaoHomologada->isEmpty();

        if (true == $canRemove) {
            (new RequisicaoItemModel($this->entityManager))->removeAll($requisicao);
            (new RequisicaoHomologadaModel($this->entityManager))->removeAll($requisicao);
        }

        return $canRemove;
    }

    /**
     * @param Requisicao $requisicao
     */
    public function removeRequisicaoDependencies(Requisicao $requisicao)
    {
    }

    /**
     * @param string $exercicio
     * @param int $codAlmoxarifado
     * @return int
     */
    public function buildCodRequisicao($exercicio, $codAlmoxarifado)
    {
        return $this->repository->getNextCodRequisicao($exercicio, $codAlmoxarifado);
    }

    /**
     * Retorna um array de requisicoes sem devoluçoes
     *
     * @return array|null
     */
    public function getRequisicoesSemDevolucao()
    {
        return $this->repository->getTodasRequisicoesSemDevolucao();
    }

    /**
     * Retorna um array de requisicoes para efetuar saida
     *
     * @return array|null
     */
    public function getRequisicoesParaDevolucao()
    {
        return $this->repository->getTodasRequisicoesParaDevolucao();
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param $tipo
     * @return ProxyQuery
     */
    public function getRequisicoes(ProxyQuery $proxyQuery, $tipo)
    {
        $tipo = strtolower(substr($tipo, 0, 1));

        $results = [];
        switch ($tipo) {
            case "s":
                $results = $this->getRequisicoesParaDevolucao();
                break;
            case "e":
                $results = $this->getRequisicoesSemDevolucao();
                break;
        }

        $alias = $proxyQuery->getRootAlias();

        $ids = [];
        foreach ($results as $requisicaoId) {
            $ids[] = $requisicaoId['cod_requisicao'];
        }

        $requisicoes = (empty($ids) ? 0 : $ids);

        $proxyQuery
            ->andWhere(
                $proxyQuery->expr()->in("{$alias}.codRequisicao", $requisicoes)
            )
        ;

        return $proxyQuery;
    }

    /**
     * Valida se a Requisicao enviada por param esta disponivel para Homologaçao
     *
     * @param Requisicao $requisicao
     * @return bool
     */
    public function isPassivelHomologacao(Requisicao $requisicao)
    {
        $results = $this->repository->getIfRequisicaoPassivelHomologacao(
            $requisicao->getExercicio(),
            $requisicao->getCodRequisicao(),
            $requisicao->getCodAlmoxarifado()
        );

        $isPassivelHomologacao = count($results) > 0 ? true : false;

        return $isPassivelHomologacao;
    }

    /**
     * @param string $exercicio
     * @param Almoxarifado $almoxarifado
     * @param Usuario $usuario
     * @param SwCgm $swCgm
     * @return Requisicao
     */
    public function buildRequisicao($exercicio, $almoxarifado, $usuario, $swCgm)
    {
        $requisicao = new Requisicao();
        $requisicao->setCodRequisicao($this->buildCodRequisicao($exercicio, $almoxarifado->getCodAlmoxarifado()));
        $requisicao->setExercicio($exercicio);
        $requisicao->setFkAlmoxarifadoAlmoxarifado($almoxarifado);
        $requisicao->setFkSwCgm($swCgm);
        $requisicao->setFkAdministracaoUsuario($usuario);
        return $requisicao;
    }

    /**
    * @param Requisicao $requisicao
    * @param Usuario $usuario
    * @return void
    */
    public function homologarRequisicao(Requisicao $requisicao, Usuario $usuario)
    {
        $requisicao->setStatus(Requisicao::STATUS_PENDENTE_AUTORIZACAO);

        $requisicaoHomologada = new RequisicaoHomologada();
        $requisicaoHomologada->setHomologada(true);
        $requisicaoHomologada->setFkAdministracaoUsuario($usuario);
        $requisicaoHomologada->setFkAlmoxarifadoRequisicao($requisicao);

        $requisicao->addFkAlmoxarifadoRequisicaoHomologadas($requisicaoHomologada);
    }

    /**
    * @param Requisicao $requisicao
    * @return void
    */
    public function anularRequisicao(Requisicao $requisicao, $motivo = '')
    {
        $requisicao->setStatus(Requisicao::STATUS_ANULADA);

        $requisicaoAnulacao = new RequisicaoAnulacao();
        $requisicaoAnulacao->setFkAlmoxarifadoRequisicao($requisicao);
        $requisicaoAnulacao->setMotivo($motivo);

        foreach ($requisicao->getFkAlmoxarifadoRequisicaoItens() as $requisicaoItem) {
            $requisicaoItensAnulacao = new RequisicaoItensAnulacao();
            $requisicaoItensAnulacao->setQuantidade($requisicaoItem->getQuantidade());
            $requisicaoItensAnulacao->setFkAlmoxarifadoRequisicaoItem($requisicaoItem);
            $requisicaoItensAnulacao->setFkAlmoxarifadoRequisicaoAnulacao($requisicaoAnulacao);

            $requisicaoAnulacao->addFkAlmoxarifadoRequisicaoItensAnulacoes($requisicaoItensAnulacao);
        }

        $requisicao->addFkAlmoxarifadoRequisicaoAnulacoes($requisicaoAnulacao);
    }

    /**
    * @param Requisicao $requisicao
    * @return void
    */
    public function anularHomologacao(Requisicao $requisicao)
    {
        $requisicao->setStatus(Requisicao::STATUS_PENDENTE_HOMOLOGACAO);

        foreach ($requisicao->getFkAlmoxarifadoRequisicaoHomologadas() as $requisicaoHomologada) {
            $requisicao->removeFkAlmoxarifadoRequisicaoHomologadas($requisicaoHomologada);
        }
    }

    /**
    * @param Requisicao $requisicao
    * @param string("total", "parcial") $tipoAutorizacao
    * @param int(>0) $qtdAprovadaParcial
    * @param string("pendente-autorizacao", "recusada")|null $statusRequisicaoFilha
    * @throws InvalidArgumentException
    * @return void
    */
    public function autorizarRequisicao(Requisicao $requisicao, $tipoAutorizacao, $qtdAprovadaParcial, $statusRequisicaoFilha = null)
    {
        if ($requisicao->getStatus() != Requisicao::STATUS_PENDENTE_AUTORIZACAO) {
            throw new InvalidArgumentException();
        }

        $requisicao->setStatus(Requisicao::STATUS_AUTORIZADA_TOTAL);

        foreach ($requisicao->getFkAlmoxarifadoRequisicaoItens() as $requisicaoItem) {
            $qtdAprovada = $requisicaoItem->getQuantidadePendente();
            if ($tipoAutorizacao == Requisicao::STATUS_AUTORIZADA_PARCIAL) {
                $qtdAprovada = $qtdAprovadaParcial;
            }

            $qtdPendente = $requisicaoItem->getQuantidadePendente();
            $saldoEstoque =  (new RequisicaoItemModel($this->entityManager))->getSaldoEstoqueByRequisicaoItem($requisicaoItem);

            $qtdAprovadaParcial = min($qtdAprovada, $qtdPendente, $saldoEstoque);
            if ($qtdAprovadaParcial <= 0) {
                throw new InvalidArgumentException();
            }

            $requisicaoItem->setQuantidadeAprovada($qtdAprovadaParcial);

            $qtdPendente = max($qtdPendente - $qtdAprovadaParcial, 0);
            $requisicaoItem->setQuantidadePendente($qtdPendente);

            if (!$qtdPendente) {
                continue;
            }

            $requisicao->setStatus(Requisicao::STATUS_AUTORIZADA_PARCIAL);
            $statusRequisicaoFilha = $statusRequisicaoFilha ?: Requisicao::STATUS_PENDENTE_AUTORIZACAO;

            $this->criarRequisicaoFilha($requisicao, $requisicaoItem, $qtdPendente, $statusRequisicaoFilha);
        }
    }

    /**
    * @param Requisicao $requisicao
    * @param RequisicaoItem $requisicaoItem
    * @param int(>0) $qtdPendente
    * @param string("pendente-autorizacao", "recusada") $statusRequisicaoFilha
    * @return void
    */
    public function criarRequisicaoFilha(Requisicao $requisicao, RequisicaoItem $requisicaoItem, $qtdPendente, $statusRequisicaoFilha)
    {
        $requisicaoFilha = new Requisicao();
        $ultimaRequisicao = $this->repository->findOneBy([], ['codRequisicao' => 'DESC']);
        $codRequisicao = $ultimaRequisicao ? $ultimaRequisicao->getCodRequisicao() : 0;
        $requisicaoFilha->setCodRequisicao(++$codRequisicao);

        $requisicaoFilha->setFkAlmoxarifadoAlmoxarifado($requisicao->getFkAlmoxarifadoAlmoxarifado());
        $requisicaoFilha->setExercicio($requisicao->getExercicio());
        $requisicaoFilha->setStatus($statusRequisicaoFilha);
        $requisicaoFilha->setFkSwCgm($requisicao->getFkSwCgm());
        $requisicaoFilha->setFkAdministracaoUsuario($requisicao->getFkAdministracaoUsuario());
        $requisicaoFilha->setObservacao($requisicao->getObservacao());

        $requisicaoItemFilha = new RequisicaoItem();
        $requisicaoItemFilha->setQuantidade($qtdPendente);
        $requisicaoItemFilha->setQuantidadePendente($qtdPendente);

        $requisicaoItemFilha->setFkAlmoxarifadoEstoqueMaterial($requisicaoItem->getFkAlmoxarifadoEstoqueMaterial());

        $requisicaoItemFilha->setFkAlmoxarifadoRequisicao($requisicaoFilha);
        $requisicaoFilha->addFkAlmoxarifadoRequisicaoItens($requisicaoItemFilha);

        $requisicaoHomologada = $requisicao->getFkAlmoxarifadoRequisicaoHomologadas()->last();
        if ($requisicaoHomologada) {
            $requisicaoHomologadaFilha = new RequisicaoHomologada();
            $requisicaoHomologadaFilha->setHomologada(true);
            $requisicaoHomologadaFilha->setFkAdministracaoUsuario($requisicaoHomologada->getFkAdministracaoUsuario());
            $requisicaoHomologadaFilha->setFkAlmoxarifadoRequisicao($requisicaoFilha);

            $requisicaoFilha->addFkAlmoxarifadoRequisicaoHomologadas($requisicaoHomologadaFilha);
        }

        $requisicaoFilha->setFkAlmoxarifadoRequisicaoPai($requisicao);
        $requisicao->addFkAlmoxarifadoRequisicaoFilha($requisicaoFilha);
    }

    /**
    * @param Requisicao $requisicao
    * @return void
    */
    public function recusarRequisicao(Requisicao $requisicao)
    {
        $requisicao->setStatus(Requisicao::STATUS_RECUSADA);
        foreach ($requisicao->getFkAlmoxarifadoRequisicaoItens() as $requisicaoItem) {
            $requisicaoItem->setQuantidadeRecusada($requisicaoItem->getQuantidadePendente());
            $requisicaoItem->setQuantidadePendente(0);
        }
    }
}
