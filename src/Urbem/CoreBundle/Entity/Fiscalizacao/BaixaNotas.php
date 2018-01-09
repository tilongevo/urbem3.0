<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * BaixaNotas
 */
class BaixaNotas
{
    /**
     * PK
     * @var integer
     */
    private $codBaixa;

    /**
     * PK
     * @var integer
     */
    private $nrNota;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao
     */
    private $fkFiscalizacaoBaixaAutorizacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\TipoInutilizacao
     */
    private $fkFiscalizacaoTipoInutilizacao;


    /**
     * Set codBaixa
     *
     * @param integer $codBaixa
     * @return BaixaNotas
     */
    public function setCodBaixa($codBaixa)
    {
        $this->codBaixa = $codBaixa;
        return $this;
    }

    /**
     * Get codBaixa
     *
     * @return integer
     */
    public function getCodBaixa()
    {
        return $this->codBaixa;
    }

    /**
     * Set nrNota
     *
     * @param integer $nrNota
     * @return BaixaNotas
     */
    public function setNrNota($nrNota)
    {
        $this->nrNota = $nrNota;
        return $this;
    }

    /**
     * Get nrNota
     *
     * @return integer
     */
    public function getNrNota()
    {
        return $this->nrNota;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return BaixaNotas
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoBaixaAutorizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao
     * @return BaixaNotas
     */
    public function setFkFiscalizacaoBaixaAutorizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao $fkFiscalizacaoBaixaAutorizacao)
    {
        $this->codBaixa = $fkFiscalizacaoBaixaAutorizacao->getCodBaixa();
        $this->fkFiscalizacaoBaixaAutorizacao = $fkFiscalizacaoBaixaAutorizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoBaixaAutorizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\BaixaAutorizacao
     */
    public function getFkFiscalizacaoBaixaAutorizacao()
    {
        return $this->fkFiscalizacaoBaixaAutorizacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoTipoInutilizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TipoInutilizacao $fkFiscalizacaoTipoInutilizacao
     * @return BaixaNotas
     */
    public function setFkFiscalizacaoTipoInutilizacao(\Urbem\CoreBundle\Entity\Fiscalizacao\TipoInutilizacao $fkFiscalizacaoTipoInutilizacao)
    {
        $this->codTipo = $fkFiscalizacaoTipoInutilizacao->getCodTipo();
        $this->fkFiscalizacaoTipoInutilizacao = $fkFiscalizacaoTipoInutilizacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoTipoInutilizacao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\TipoInutilizacao
     */
    public function getFkFiscalizacaoTipoInutilizacao()
    {
        return $this->fkFiscalizacaoTipoInutilizacao;
    }
}
