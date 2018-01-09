<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * ProcessoLevantamento
 */
class ProcessoLevantamento
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $competencia;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento
     */
    private $fkFiscalizacaoLevantamento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoFonte
     */
    private $fkFiscalizacaoRetencaoFonte;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico
     */
    private $fkFiscalizacaoFaturamentoServicos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa
     */
    private $fkFiscalizacaoProcessoFiscalEmpresa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoFaturamentoServicos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoLevantamento
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return ProcessoLevantamento
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico
     * @return ProcessoLevantamento
     */
    public function addFkFiscalizacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico)
    {
        if (false === $this->fkFiscalizacaoFaturamentoServicos->contains($fkFiscalizacaoFaturamentoServico)) {
            $fkFiscalizacaoFaturamentoServico->setFkFiscalizacaoProcessoLevantamento($this);
            $this->fkFiscalizacaoFaturamentoServicos->add($fkFiscalizacaoFaturamentoServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoFaturamentoServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico
     */
    public function removeFkFiscalizacaoFaturamentoServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico $fkFiscalizacaoFaturamentoServico)
    {
        $this->fkFiscalizacaoFaturamentoServicos->removeElement($fkFiscalizacaoFaturamentoServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoFaturamentoServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FaturamentoServico
     */
    public function getFkFiscalizacaoFaturamentoServicos()
    {
        return $this->fkFiscalizacaoFaturamentoServicos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoProcessoFiscalEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa $fkFiscalizacaoProcessoFiscalEmpresa
     * @return ProcessoLevantamento
     */
    public function setFkFiscalizacaoProcessoFiscalEmpresa(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa $fkFiscalizacaoProcessoFiscalEmpresa)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoFiscalEmpresa->getCodProcesso();
        $this->fkFiscalizacaoProcessoFiscalEmpresa = $fkFiscalizacaoProcessoFiscalEmpresa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoProcessoFiscalEmpresa
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalEmpresa
     */
    public function getFkFiscalizacaoProcessoFiscalEmpresa()
    {
        return $this->fkFiscalizacaoProcessoFiscalEmpresa;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoLevantamento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento $fkFiscalizacaoLevantamento
     * @return ProcessoLevantamento
     */
    public function setFkFiscalizacaoLevantamento(\Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento $fkFiscalizacaoLevantamento)
    {
        $fkFiscalizacaoLevantamento->setFkFiscalizacaoProcessoLevantamento($this);
        $this->fkFiscalizacaoLevantamento = $fkFiscalizacaoLevantamento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoLevantamento
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Levantamento
     */
    public function getFkFiscalizacaoLevantamento()
    {
        return $this->fkFiscalizacaoLevantamento;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoRetencaoFonte
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoFonte $fkFiscalizacaoRetencaoFonte
     * @return ProcessoLevantamento
     */
    public function setFkFiscalizacaoRetencaoFonte(\Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoFonte $fkFiscalizacaoRetencaoFonte)
    {
        $fkFiscalizacaoRetencaoFonte->setFkFiscalizacaoProcessoLevantamento($this);
        $this->fkFiscalizacaoRetencaoFonte = $fkFiscalizacaoRetencaoFonte;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoRetencaoFonte
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\RetencaoFonte
     */
    public function getFkFiscalizacaoRetencaoFonte()
    {
        return $this->fkFiscalizacaoRetencaoFonte;
    }
}
