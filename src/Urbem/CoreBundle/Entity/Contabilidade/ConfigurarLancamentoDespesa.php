<?php

namespace Urbem\CoreBundle\Entity\Contabilidade;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class ConfigurarLancamentoDespesa
{
    private $codFake;

    private $listaDespesaFiltro;

    private $despesaFiltro;

    private $lancamento;

    private $debitoLiquidacaoLancamento;

    private $creditoLiquidacaoLancamento;

    private $debitoAlmoxarifadoLancamento;

    private $creditoAlmoxarifadoLancamento;

    /**
     * @return int
     */
    public function getCodFake()
    {
        return $this->codFake;
    }

    /**
     * @param int $codFake
     */
    public function setCodFake($codFake)
    {
        $this->codFake = $codFake;
    }

    /**
     * @return mixed
     */
    public function getListaDespesaFiltro()
    {
        return $this->listaDespesaFiltro;
    }

    /**
     * @param mixed $listaDespesaFiltro
     */
    public function setListaDespesaFiltro($listaDespesaFiltro)
    {
        $this->listaDespesaFiltro = $listaDespesaFiltro;
    }

    /**
     * @return mixed
     */
    public function getDespesaFiltro()
    {
        return $this->despesaFiltro;
    }

    /**
     * @param mixed $despesaFiltro
     */
    public function setDespesaFiltro($despesaFiltro)
    {
        $this->despesaFiltro = $despesaFiltro;
    }

    /**
     * @return mixed
     */
    public function getLancamento()
    {
        return $this->lancamento;
    }

    /**
     * @param mixed $lancamento
     */
    public function setLancamento($lancamento)
    {
        $this->lancamento = $lancamento;
    }

    /**
     * @return mixed
     */
    public function getDebitoLiquidacaoLancamento()
    {
        return $this->debitoLiquidacaoLancamento;
    }

    /**
     * @param mixed $debitoLiquidacaoLancamento
     */
    public function setDebitoLiquidacaoLancamento($debitoLiquidacaoLancamento)
    {
        $this->debitoLiquidacaoLancamento = $debitoLiquidacaoLancamento;
    }

    /**
     * @return mixed
     */
    public function getCreditoLiquidacaoLancamento()
    {
        return $this->creditoLiquidacaoLancamento;
    }

    /**
     * @param mixed $creditoLiquidacaoLancamento
     */
    public function setCreditoLiquidacaoLancamento($creditoLiquidacaoLancamento)
    {
        $this->creditoLiquidacaoLancamento = $creditoLiquidacaoLancamento;
    }

    /**
     * @return mixed
     */
    public function getDebitoAlmoxarifadoLancamento()
    {
        return $this->debitoAlmoxarifadoLancamento;
    }

    /**
     * @param mixed $debitoAlmoxarifadoLancamento
     */
    public function setDebitoAlmoxarifadoLancamento($debitoAlmoxarifadoLancamento)
    {
        $this->debitoAlmoxarifadoLancamento = $debitoAlmoxarifadoLancamento;
    }

    /**
     * @return mixed
     */
    public function getCreditoAlmoxarifadoLancamento()
    {
        return $this->creditoAlmoxarifadoLancamento;
    }

    /**
     * @param mixed $creditoAlmoxarifadoLancamento
     */
    public function setCreditoAlmoxarifadoLancamento($creditoAlmoxarifadoLancamento)
    {
        $this->creditoAlmoxarifadoLancamento = $creditoAlmoxarifadoLancamento;
    }
}
