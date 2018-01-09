<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * Fiscal
 */
class Fiscal
{
    /**
     * PK
     * @var integer
     */
    private $codFiscal;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codContrato;

    /**
     * @var boolean
     */
    private $administrador;

    /**
     * @var boolean
     */
    private $ativo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao
     */
    private $fkFiscalizacaoFiscalFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    private $fkFiscalizacaoFiscalProcessoFiscais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    private $fkSwCgmPessoaFisica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoFiscalFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoFiscalProcessoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFiscal
     *
     * @param integer $codFiscal
     * @return Fiscal
     */
    public function setCodFiscal($codFiscal)
    {
        $this->codFiscal = $codFiscal;
        return $this;
    }

    /**
     * Get codFiscal
     *
     * @return integer
     */
    public function getCodFiscal()
    {
        return $this->codFiscal;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Fiscal
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return Fiscal
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set administrador
     *
     * @param boolean $administrador
     * @return Fiscal
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;
        return $this;
    }

    /**
     * Get administrador
     *
     * @return boolean
     */
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Fiscal
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoFiscalFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao $fkFiscalizacaoFiscalFiscalizacao
     * @return Fiscal
     */
    public function addFkFiscalizacaoFiscalFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao $fkFiscalizacaoFiscalFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoFiscalFiscalizacoes->contains($fkFiscalizacaoFiscalFiscalizacao)) {
            $fkFiscalizacaoFiscalFiscalizacao->setFkFiscalizacaoFiscal($this);
            $this->fkFiscalizacaoFiscalFiscalizacoes->add($fkFiscalizacaoFiscalFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoFiscalFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao $fkFiscalizacaoFiscalFiscalizacao
     */
    public function removeFkFiscalizacaoFiscalFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao $fkFiscalizacaoFiscalFiscalizacao)
    {
        $this->fkFiscalizacaoFiscalFiscalizacoes->removeElement($fkFiscalizacaoFiscalFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoFiscalFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao
     */
    public function getFkFiscalizacaoFiscalFiscalizacoes()
    {
        return $this->fkFiscalizacaoFiscalFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     * @return Fiscal
     */
    public function addFkFiscalizacaoFiscalProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal)
    {
        if (false === $this->fkFiscalizacaoFiscalProcessoFiscais->contains($fkFiscalizacaoFiscalProcessoFiscal)) {
            $fkFiscalizacaoFiscalProcessoFiscal->setFkFiscalizacaoFiscal($this);
            $this->fkFiscalizacaoFiscalProcessoFiscais->add($fkFiscalizacaoFiscalProcessoFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     */
    public function removeFkFiscalizacaoFiscalProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal)
    {
        $this->fkFiscalizacaoFiscalProcessoFiscais->removeElement($fkFiscalizacaoFiscalProcessoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoFiscalProcessoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    public function getFkFiscalizacaoFiscalProcessoFiscais()
    {
        return $this->fkFiscalizacaoFiscalProcessoFiscais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgmPessoaFisica
     *
     * @param \Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica
     * @return Fiscal
     */
    public function setFkSwCgmPessoaFisica(\Urbem\CoreBundle\Entity\SwCgmPessoaFisica $fkSwCgmPessoaFisica)
    {
        $this->numcgm = $fkSwCgmPessoaFisica->getNumcgm();
        $this->fkSwCgmPessoaFisica = $fkSwCgmPessoaFisica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgmPessoaFisica
     *
     * @return \Urbem\CoreBundle\Entity\SwCgmPessoaFisica
     */
    public function getFkSwCgmPessoaFisica()
    {
        return $this->fkSwCgmPessoaFisica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return Fiscal
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }
}
