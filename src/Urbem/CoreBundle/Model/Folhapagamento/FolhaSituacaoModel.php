<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao;
use Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacaoFechada;
use Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\FolhaSituacaoRepository;

class FolhaSituacaoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var FolhaSituacaoRepository|null  */
    protected $repository = null;

    /**
     * FolhaSituacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\FolhaSituacao");
    }

    /**
     * @param $cod_periodo_movimentacao
     * @return mixed
     */
    public function getFolhaSituacaoByMaxTimestapAndCodPeriodoMovimentacao($cod_periodo_movimentacao)
    {
        return $this->repository->getFolhaSituacaoByMaxTimestapAndCodPeriodoMovimentacao($cod_periodo_movimentacao);
    }

    /**
     * @param        $codPeriodoMovimentacao
     * @param string $situacao
     *
     * @return mixed
     */
    public function montaRecuperaRelacionamento($codPeriodoMovimentacao, $situacao = 'f')
    {
        return $this->repository->montaRecuperaRelacionamento($codPeriodoMovimentacao, $situacao);
    }

    /**
     * @param $codPeriodoMovimentacao
     * @param $situacao
     * @return mixed
     */
    public function montaRecuperaVezesFecharAbrirFolhaPagamento($codPeriodoMovimentacao, $situacao)
    {
        return $this->repository->montaRecuperaVezesFecharAbrirFolhaPagamento($codPeriodoMovimentacao, $situacao);
    }

    /**
     * @param bool $filtro
     * @return object
     */
    public function recuperaUltimaFolhaSituacao($filtro = false)
    {
        return $this->repository->recuperaUltimaFolhaSituacao($filtro);
    }

    /**
     * @param integer $codPeriodoMovimentacao
     * @return array
     */
    public function getComplementarSituacaoAFechar($codPeriodoMovimentacao)
    {
        return $this->repository->getComplementarSituacaoAFechar($codPeriodoMovimentacao);
    }

    /**
     * @param FolhaSituacao $folhaSituacao
     */
    public function manterComplementarSituacaoFechada($folhaSituacao)
    {
        $complementaresAFechar = $this->getComplementarSituacaoAFechar($folhaSituacao->getCodPeriodoMovimentacao());

        if (count($complementaresAFechar)) {
            foreach ($complementaresAFechar as $complementarAFechar) {
                /** @var ComplementarSituacao $complementarSituacao */
                $complementarSituacao = $this->entityManager->getRepository(ComplementarSituacao::class)->findOneBy([
                    'codPeriodoMovimentacao' => $complementarAFechar['cod_periodo_movimentacao'],
                    'codComplementar' => $complementarAFechar['cod_complementar'],
                    'timestamp' => $complementarAFechar['timestamp'],
                ]);

                $complementarSituacaoFechada = new ComplementarSituacaoFechada();
                $complementarSituacaoFechada->setFkFolhapagamentoComplementarSituacao($complementarSituacao);
                $folhaSituacao->addFkFolhapagamentoComplementarSituacaoFechadas($complementarSituacaoFechada);
            }
        }
    }
}
