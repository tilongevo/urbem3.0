<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * ProcessoFiscalEmpresa
 */
class ProcessoFiscalEmpresa
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento
     */
    private $fkFiscalizacaoProcessoLevantamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoProcessoLevantamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return ProcessoFiscalEmpresa
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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return ProcessoFiscalEmpresa
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoLevantamento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento
     * @return ProcessoFiscalEmpresa
     */
    public function addFkFiscalizacaoProcessoLevantamentos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento)
    {
        if (false === $this->fkFiscalizacaoProcessoLevantamentos->contains($fkFiscalizacaoProcessoLevantamento)) {
            $fkFiscalizacaoProcessoLevantamento->setFkFiscalizacaoProcessoFiscalEmpresa($this);
            $this->fkFiscalizacaoProcessoLevantamentos->add($fkFiscalizacaoProcessoLevantamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoLevantamento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento
     */
    public function removeFkFiscalizacaoProcessoLevantamentos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento)
    {
        $this->fkFiscalizacaoProcessoLevantamentos->removeElement($fkFiscalizacaoProcessoLevantamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoLevantamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento
     */
    public function getFkFiscalizacaoProcessoLevantamentos()
    {
        return $this->fkFiscalizacaoProcessoLevantamentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return ProcessoFiscalEmpresa
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return ProcessoFiscalEmpresa
     */
    public function setFkFiscalizacaoProcessoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoFiscal->getCodProcesso();
        $this->fkFiscalizacaoProcessoFiscal = $fkFiscalizacaoProcessoFiscal;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoProcessoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscal()
    {
        return $this->fkFiscalizacaoProcessoFiscal;
    }
}
