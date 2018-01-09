<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoInstrumento
 */
class TipoInstrumento
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codigoTc;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    private $fkLicitacaoContratos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkLicitacaoContratos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoInstrumento
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
     * Set codigoTc
     *
     * @param integer $codigoTc
     * @return TipoInstrumento
     */
    public function setCodigoTc($codigoTc = null)
    {
        $this->codigoTc = $codigoTc;
        return $this;
    }

    /**
     * Get codigoTc
     *
     * @return integer
     */
    public function getCodigoTc()
    {
        return $this->codigoTc;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoInstrumento
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return TipoInstrumento
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
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return TipoInstrumento
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkLicitacaoTipoInstrumento($this);
            $this->fkLicitacaoContratos->add($fkLicitacaoContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     */
    public function removeFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        $this->fkLicitacaoContratos->removeElement($fkLicitacaoContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Contrato
     */
    public function getFkLicitacaoContratos()
    {
        return $this->fkLicitacaoContratos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->codTipo;
    }
}
