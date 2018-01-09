<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 27/07/16
 * Time: 15:40
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

class ComissaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const PREGOEIRO = 'Pregoeiro';
    const PRESIDENTE = 'Presidente';
    const COMISSAO_PERMANENTE = 1;
    const COMISSAO_ESPECIAL = 2;
    const COMISSAO_PREGOEIRO = 3;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licitacao\Comissao::class);
    }

    public function getComissaoAtivas()
    {
        return $this->repository->getComissaoAtivas();
    }

    public function getMembrosComissao($codComissao)
    {
        return $this->repository->getMembrosComissao($codComissao);
    }

    /**
     * @param Licitacao\Comissao $comissao
     * @param array $comissaoMembros
     * @return bool|string
     */
    public function validaComissao(Licitacao\Comissao $comissao, array $comissaoMembros)
    {
        $boPregoeiro = $boPresidente = $obErro = false;
        $inContPresidente = $inContPregoeiro = 0;
        $comissaoMembros = empty($comissaoMembros) ? $comissao->getFkLicitacaoComissaoMembros() : $comissaoMembros;
        foreach ($comissaoMembros as $membros) {
            if ($membros->getFkLicitacaoTipoMembro()->getDescricao() == self::PRESIDENTE) {
                $boPresidente = true;
                $inContPresidente++;
            }
            if ($membros->getFkLicitacaoTipoMembro()->getDescricao() == self::PREGOEIRO) {
                $boPregoeiro = true;
                $inContPregoeiro++;
            }
        }

        if ($comissao->getCodTipoComissao() == self::COMISSAO_PERMANENTE && !$boPresidente) {
            $obErro = 'comissao.errors.escolhaUmPresidente';
        }
        if ($comissao->getCodTipoComissao() == self::COMISSAO_ESPECIAL && (!$boPregoeiro && !$boPresidente)) {
            $obErro = 'comissao.errors.escolhaUmPresidenteOuPregoeiro';
        }
        if ($comissao->getCodTipoComissao() == self::COMISSAO_PREGOEIRO && !$boPregoeiro) {
            $obErro = 'comissao.errors.escolhaUmPregoeiro';
        }

        if (!$obErro) {
            if ($inContPresidente > 1) {
                $obErro = 'comissao.errors.cadastreApenasUmPresidente';
            }

            if ($inContPregoeiro > 1) {
                $obErro = 'comissao.errors.cadastreApenasUmPregoeiro';
            }
        }

        return $obErro;
    }

    /**
     * @param Licitacao\Comissao $comissao
     * @param array $comissaoMembros
     * @param $anoAtual
     * @return bool|string
     */
    public function validaComissaoVigencia(Licitacao\Comissao $comissao, array $comissaoMembros, $anoAtual)
    {
        $obErro = false;
        $comissaoMembros = empty($comissaoMembros) ? $comissao->getFkLicitacaoComissaoMembros() : $comissaoMembros;
        foreach ($comissaoMembros as $membros) {
            if (!is_null($membros->getFkNormasNorma()->getFkNormasNormaDataTermino()->getDtTermino())) {
                $dataTermino = (int) $membros->getFkNormasNorma()->getFkNormasNormaDataTermino()->getDtTermino()->format("Y");
                if ($anoAtual > $dataTermino) {
                    $obErro = 'comissaoVigencia.errors.vigenciaDataExpiradaComissao';
                }
            } else {
                $obErro = 'comissaoVigencia.errors.vigenciaNulaComissao';
            }
        }
        return $obErro;
    }
}
