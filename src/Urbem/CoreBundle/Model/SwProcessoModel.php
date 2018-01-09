<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\SwAndamento;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwProcessoInteressado;
use Urbem\CoreBundle\Entity\SwSituacaoProcesso;
use Urbem\CoreBundle\Entity\SwRecebimento;
use Urbem\CoreBundle\Entity\SwAssinaturaDigital;
use Urbem\CoreBundle\Entity\SwDespacho;
use Urbem\CoreBundle\Entity\SwProcessoArquivado;
use Urbem\CoreBundle\Entity\SwHistoricoArquivamento;
use Urbem\CoreBundle\Entity\SwProcessoApensado;
use Urbem\CoreBundle\Helper\DateTimePK;
use Urbem\CoreBundle\Model\Organograma\VwOrgaoNivelViewModel;

/**
 * Class SwProcessoModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwProcessoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null|\Urbem\CoreBundle\Repository\SwProcessoRepository */
    protected $repository = null;
    protected $repositorySwAtributoProtocolo = null;

    /**
     * SwProcessoModel constructor.
     *
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SwProcesso::class);
        $this->repositorySwAtributoProtocolo = $entityManager->getRepository('CoreBundle:SwAtributoProtocolo');
    }

    /**
     * @param ProxyQueryInterface $proxyQuery
     *
     * @return ProxyQueryInterface
     */
    public function getListaProcessosNaoConfidenciais(ProxyQueryInterface $proxyQuery)
    {
        $repositoryResult = $this->repository->getListaDeProcessosNaoConfidenciais();

        $aliases = $proxyQuery->getRootAliases();
        $alias = reset($aliases);

        $codigos = [];
        foreach ($repositoryResult as $item) {
            $codigos[] = $item['cod_processo'] . $item['ano_exercicio'];
        }

        if ($codigos) {
            $proxyQuery
                ->where($proxyQuery->expr()->in(
                    $proxyQuery->expr()->concat("{$alias}.codProcesso", "{$alias}.anoExercicio"),
                    $codigos
                ));
        }

        return $proxyQuery;
    }

    /**
     * @return ArrayCollection processos
     */
    public function getProcessosAdministrativos($query = null, $limit = null, $offset = null)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $processoQB = $qb
            ->select([
                'processo.codProcesso', 'processo.anoExercicio', '(processo.codClassificacao) AS codClassificacao',
                '(processo.codAssunto) AS codAssunto', '(processo.codSituacao) AS codSituacao',
                'processo.timestamp', 'processo.observacoes', 'processo.confidencial', 'processo.resumoAssunto',
                'assunto.nomAssunto', 'classificacao.nomClassificacao', 'cgm.nomCgm', 'cgm.numcgm'
            ])
            ->from(SwProcesso::class, 'processo')
            ->join('processo.fkSwAssunto', 'assunto')
            ->join('processo.fkSwProcessoInteressados', 'processo_interessado')
            ->join('processo_interessado.fkSwCgm', 'cgm')
            ->join(
                SwClassificacao::class,
                'classificacao',
                'WITH',
                'processo.codClassificacao = classificacao.codClassificacao'
            );

        if ($query) {
            if (is_numeric($query)) {
                $processoQB
                    ->orWhere("processo.codProcesso = :value")
                    ->setParameter('value', $query);
            }
            $processoQB
                ->orWhere('LOWER(assunto.nomAssunto) like :query')
                ->orWhere('LOWER(cgm.nomCgm) like :query')
                ->setParameter('query', strtolower("%$query%"));
        }

        if ($offset) {
            $processoQB->setFirstResult($offset);
        }

        if ($limit) {
            $processoQB->setMaxResults($limit);
        }

        $processos = [];
        foreach ($processoQB->getQuery()->getResult() as $key => $processo) {
            $processos[$key]['swProcesso'] = $this->repository->findOneBy([
                'codProcesso'  => $processo['codProcesso'],
                'anoExercicio' => $processo['anoExercicio']
            ]);
            $processos[$key]['swCgm'] = $this->entityManager->getRepository(SwCgm::class)->find($processo['numcgm']);
        }
        $processos = new ArrayCollection($processos);

        // ATT: Se for alterar, verificar o comportamento do campo codProcesso em CompraDiretaAdmin

        return $processos;
    }

    public function encaminhar(SwProcesso $processo, SwSituacaoProcesso $situacao, $usuario, Orgao $orgao)
    {
        $swAndamento = new SwAndamento();
        $swAndamento->setFkSwProcesso($processo);
        $swAndamento->setAnoExercicio($processo->getAnoExercicio());
        $swAndamento->setCodUsuario($usuario->getNumcgm());
        $swAndamento->setFkSwSituacaoProcesso($situacao);
        $swAndamento->setFkOrganogramaOrgao($orgao);

        $lastCodAndamento = $this->entityManager->getRepository(SwAndamento::class)->findOneBy(
            [
                'codProcesso'  => $swAndamento->getCodProcesso(),
                'anoExercicio' => $swAndamento->getAnoExercicio()
            ],
            [
                'codAndamento' => 'DESC'
            ]
        );
        $swAndamento->setCodAndamento($lastCodAndamento->getCodAndamento() + 1);

        $this->entityManager->persist($swAndamento);
        $this->entityManager->flush($swAndamento);
        $processo->setFkSwSituacaoProcesso($situacao);
        $this->save($processo);
    }

    /**
     * Receber Processo
     *
     * @param SwProcesso $swProcesso
     * @param Usuario    $usuario
     *
     * @internal param SwSituacaoProcesso $situacao
     */
    public function receber(SwProcesso $swProcesso, Usuario $usuario)
    {
        /** @var SwSituacaoProcesso $swSituacaoProcesso */
        $swSituacaoProcesso = $this->entityManager
            ->getRepository(SwSituacaoProcesso::class)
            ->findOneBy(['nomSituacao' => 'Em andamento, recebido']);

        /** @var SwAndamento $swAndamento */
        $swAndamento = $this->entityManager
            ->getRepository(SwAndamento::class)
            ->findOneBy([
                'codProcesso'  => $swProcesso->getCodProcesso(),
                'anoExercicio' => $swProcesso->getAnoExercicio(),
                'codSituacao'  => 2
            ], [
                'codAndamento' => 'DESC'
            ]);

        $swRecebimento = new SwRecebimento();
        $swRecebimento->setFkSwAndamento($swAndamento);

        $this->save($swRecebimento);

        $swAssinaturaDigital = new SwAssinaturaDigital();
        $swAssinaturaDigital->setFkSwRecebimento($swRecebimento);
        $swAssinaturaDigital->setFkAdministracaoUsuario($usuario);

        $this->save($swAssinaturaDigital);

        $swProcesso->setFkSwSituacaoProcesso($swSituacaoProcesso);

        $this->save($swProcesso);
    }

    /**
     * Despachar Processo
     *
     * @param SwProcesso $swProcesso
     * @param Usuario    $usuario
     * @param string     $descricao
     */
    public function despachar(SwProcesso $swProcesso, Usuario $usuario, $descricao)
    {
        /** @var SwAndamento $swAndamento */
        $swAndamento = $this->entityManager
            ->getRepository(SwAndamento::class)
            ->findOneBy([
                'codProcesso'  => $swProcesso->getCodProcesso(),
                'anoExercicio' => $swProcesso->getAnoExercicio()
            ], [
                'codAndamento' => 'DESC'
            ]);

        $swDespacho = new SwDespacho();
        $swDespacho->setFkSwAndamento($swAndamento);
        $swDespacho->setFkAdministracaoUsuario($usuario);
        $swDespacho->setDescricao($descricao);

        $this->save($swDespacho);
    }

    /**
     * @param SwProcesso $swProcesso
     *
     * @return SwDespacho|null
     */
    public function despachado(SwProcesso $swProcesso)
    {
        return $this->entityManager
            ->getRepository(SwDespacho::class)
            ->findOneBy([
                'codProcesso'  => $swProcesso->getCodProcesso(),
                'anoExercicio' => $swProcesso->getAnoExercicio()
            ]);
    }

    /**
     * Verifica se o processo já foi encaminhado.
     *
     * @param SwProcesso $swProcesso
     * @param Orgao      $orgao
     *
     * @return bool
     */
    public function encaminhado(SwProcesso $swProcesso, Orgao $orgao)
    {
        $vwOrgaoNivelViewQuery = (new VwOrgaoNivelViewModel($this->entityManager))
            ->getOrgaosNivelQuery($orgao);

        $vwOrgaoNivelViewQueryAlias = $vwOrgaoNivelViewQuery->getRootAliases();
        $vwOrgaoNivelViewQueryAlias = reset($vwOrgaoNivelViewQueryAlias);
        $vwOrgaoNivelViewQuery = $vwOrgaoNivelViewQuery
            ->select("{$vwOrgaoNivelViewQueryAlias}.codOrgao");

        $queryBuilder = $this->repository->createQueryBuilder('p');
        $queryBuilder
            ->join('p.fkSwAndamentos', 'a')
            ->join('p.fkSwUltimoAndamento', 'ua')
            ->join('p.fkSwSituacaoProcesso', 'sp')
            ->where('a.codAndamento = (ua.codAndamento - 1)')
            ->andWhere('sp.codSituacao = :codSituacao')
            ->andWhere('p.codProcesso = :codProcesso')
            ->andWhere('p.anoExercicio = :anoExercicio')
            ->andWhere(
                $queryBuilder->expr()->in('a.codOrgao', $vwOrgaoNivelViewQuery->getDQL())
            )
            ->setParameter('codSituacao', SwSituacaoProcesso::EM_ANDAMENTO_RECEBER)
            ->setParameter('codProcesso', $swProcesso->getCodProcesso())
            ->setParameter('anoExercicio', $swProcesso->getAnoExercicio());

        $res = $queryBuilder->getQuery()->getResult();
        return !empty($res);
    }

    /**
     * @param SwHistoricoArquivamento $swHistoricoArquivamento
     * @param SwSituacaoProcesso      $swSituacaoProcesso
     * @param SwProcesso              $swProcesso
     * @param SwCgm                   $swCgm
     * @param string                  $localizacao
     * @param string                  $textoComplementar
     */
    public function arquivar(
        SwHistoricoArquivamento $swHistoricoArquivamento,
        SwSituacaoProcesso $swSituacaoProcesso,
        SwProcesso $swProcesso,
        SwCgm $swCgm,
        $localizacao,
        $textoComplementar
    ) {
        $swProcessoArquivado = new SwProcessoArquivado();
        $swProcessoArquivado
            ->setFkSwHistoricoArquivamento($swHistoricoArquivamento)
            ->setFkSwCgm($swCgm)
            ->setFkSwProcesso($swProcesso)
            ->setLocalizacao($localizacao)
            ->setTextoComplementar($textoComplementar);

        $this->save($swProcessoArquivado);

        $swProcesso->setFkSwSituacaoProcesso($swSituacaoProcesso);

        $this->save($swProcesso);
    }

    /**
     * @param SwProcesso $swProcesso
     */
    public function desarquivar(SwProcesso $swProcesso)
    {
        $swProcessoArquivado = $swProcesso->getFkSwProcessoArquivado();
        $swProcesso->setFkSwProcessoArquivado(null);
        $this->remove($swProcessoArquivado);

        /** @var SwSituacaoProcesso $swSituacaoProcesso */
        $swSituacaoProcesso = $this->entityManager
            ->getRepository(SwSituacaoProcesso::class)
            ->find(SwSituacaoProcesso::EM_ANDAMENTO_RECEBIDO);

        $swProcesso->setFkSwSituacaoProcesso($swSituacaoProcesso);

        $this->save($swProcesso);
    }

    /**
     * Executa ação de apensar os processos usando um ArrayCollection.
     *
     * @param SwProcesso      $swProcesso
     * @param ArrayCollection $swProcessoCollection
     */
    public function apensarProcessos(SwProcesso $swProcesso, ArrayCollection $swProcessoCollection)
    {
        /** @var SwProcesso $swProcessoFilho */
        foreach ($swProcessoCollection as $swProcessoFilho) {
            $this->apensar($swProcesso, $swProcessoFilho);
        }
    }

    /**
     * Executa ação de apensar os processos.
     *
     * @param SwProcesso $swProcessoPai
     * @param SwProcesso $swProcessoFilho
     */
    public function apensar(SwProcesso $swProcessoPai, SwProcesso $swProcessoFilho)
    {
        /** @var SwSituacaoProcesso $swSituacaoProcesso */
        $swSituacaoProcesso = $this->entityManager
            ->getRepository(SwSituacaoProcesso::class)
            ->find(SwSituacaoProcesso::APENSADO);

        $swProcessoApensado = new SwProcessoApensado();
        $swProcessoApensado
            ->setCodProcessoPai($swProcessoPai->getCodProcesso())
            ->setExercicioPai($swProcessoPai->getAnoExercicio())
            ->setCodProcessoFilho($swProcessoFilho->getCodProcesso())
            ->setExercicioFilho($swProcessoFilho->getAnoExercicio());

        $this->save($swProcessoApensado);

        $swProcessoFilho->setFkSwSituacaoProcesso($swSituacaoProcesso);

        $this->save($swProcessoFilho);
    }

    /**
     * @param SwProcesso $swProcesso
     *
     * @return boolean
     */
    public function apensado(SwProcesso $swProcesso)
    {
        /** @var SwProcessoApensado $swProcessoApensado */
        $swProcessoApensado = $this->entityManager
            ->getRepository(SwProcessoApensado::class)
            ->findOneBy([
                'codProcessoPai'          => $swProcesso->getCodProcesso(),
                'exercicioPai'            => $swProcesso->getAnoExercicio(),
                'timestampDesapensamento' => null
            ]);

        return !is_null($swProcessoApensado);
    }

    /**
     * Executa ação de desapensar os processos usando um ArrayCollection.
     *
     * @param SwProcesso      $swProcesso
     * @param ArrayCollection $swProcessoCollection
     */
    public function desapensarProcessos(SwProcesso $swProcesso, ArrayCollection $swProcessoCollection)
    {
        /** @var SwProcesso $swProcessoFilho */
        foreach ($swProcessoCollection as $swProcessoFilho) {
            $this->desapensar($swProcesso, $swProcessoFilho);
        }
    }

    /**
     * Executa ação de desapensar os processos.
     *
     * @param SwProcesso $swProcessoPai
     * @param SwProcesso $swProcessoFilho
     */
    public function desapensar(SwProcesso $swProcessoPai, SwProcesso $swProcessoFilho)
    {
        /** @var SwProcessoApensado $swProcessoApensado */
        $swProcessoApensado = $this->entityManager->getRepository(SwProcessoApensado::class)->findOneBy([
            'codProcessoPai'   => $swProcessoPai->getCodProcesso(),
            'exercicioPai'     => $swProcessoPai->getAnoExercicio(),
            'codProcessoFilho' => $swProcessoFilho->getCodProcesso(),
            'exercicioFilho'   => $swProcessoFilho->getAnoExercicio(),
        ]);

        $swProcessoApensado->setTimestampDesapensamento(new \DateTime());
        $this->save($swProcessoApensado);

        $swProcessoFilho->setCodSituacao(SwSituacaoProcesso::EM_ANDAMENTO_RECEBIDO);
        $this->save($swProcessoFilho);
    }

    /**
     * @param SwProcesso $swProcesso
     */
    public function cancelarEncaminhamento(SwProcesso $swProcesso)
    {
        /** @var SwSituacaoProcesso $swSituacaoProcesso */
        $swSituacaoProcesso = $this->entityManager
            ->getRepository(SwSituacaoProcesso::class)
            ->findOneBy(['nomSituacao' => 'Em andamento, recebido']);

        /** @var SwAndamento $swAndamento */
        $swAndamento = $this->entityManager
            ->getRepository(SwAndamento::class)
            ->findOneBy([
                'codProcesso'  => $swProcesso->getCodProcesso(),
                'anoExercicio' => $swProcesso->getAnoExercicio(),
                'codAndamento' => 2
            ]);

        $this->remove($swAndamento);

        $swProcesso->setFkSwSituacaoProcesso($swSituacaoProcesso);

        $this->save($swProcesso);
    }

    public function getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto)
    {
        return $this->repository->getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto);
    }

    /**
     * @param $q
     *
     * @return ORM\QueryBuilder
     */
    public function carregaSwProcessosQuery($q)
    {
        $queryBuilder = $this->repository->createQueryBuilder('swProcesso');
        $queryBuilder->join(
            'CoreBundle:swAssunto',
            'swAssunto',
            'WITH',
            'swProcesso.codAssunto = swAssunto.codAssunto'
        );

        if (is_numeric($q)) {
            $queryBuilder->where(sprintf("swProcesso.codProcesso = %s", $q));
        } else {
            $queryBuilder->add(
                'where',
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower('swAssunto.nomAssunto'),
                    $queryBuilder->expr()->literal(sprintf('%%%s%%', $q))
                )
            );
        }

        return $queryBuilder;
    }

    /**
     * @param SwAssunto $assunto
     * @param string    $query
     *
     * @return ORM\QueryBuilder
     */
    public function findProcessosByCgmAssuntoQuery(SwAssunto $assunto, $query)
    {
        $concatExpr = "STRING(sw_processo.codProcesso)";
        $concatExpr = "LPAD({$concatExpr}, 7, '0')";
        $concatExpr = "CONCAT({$concatExpr}, '_', LPAD(sw_processo.anoExercicio, 8, '0'))";
        $concatExpr = "CONCAT({$concatExpr}, ' | ', sw_assunto.nomAssunto)";

        $queryBuilder = $this->repository->createQueryBuilder('sw_processo');
        $queryBuilder
            ->join('sw_processo.fkSwAssunto', 'sw_assunto')
            ->where('sw_assunto.codAssunto = :cod_assunto', 'sw_assunto.codClassificacao = :cod_classificacao')
            ->andWhere(
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower($concatExpr),
                    $queryBuilder->expr()->lower(':query')
                )
            )
            ->setParameter('cod_assunto', $assunto->getCodAssunto())
            ->setParameter('cod_classificacao', $assunto->getCodClassificacao())
            ->setParameter('query', '%' . $query . '%');

        return $queryBuilder;
    }

    /**
     * @param string $exercicio
     *
     * @return int
     */
    public function getNextCodProcesso($exercicio)
    {
        return $this->repository->nextCodProcesso($exercicio);
    }
}
