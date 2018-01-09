<?php
 
namespace Urbem\CoreBundle\Entity\Licitacao;

/**
 * TipoGarantia
 */
class TipoGarantia
{
    /**
     * PK
     * @var integer
     */
    private $codGarantia;

    /**
     * @var string
     */
    private $descricao;

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
     * Set codGarantia
     *
     * @param integer $codGarantia
     * @return TipoGarantia
     */
    public function setCodGarantia($codGarantia)
    {
        $this->codGarantia = $codGarantia;
        return $this;
    }

    /**
     * Get codGarantia
     *
     * @return integer
     */
    public function getCodGarantia()
    {
        return $this->codGarantia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoGarantia
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
     * OneToMany (owning side)
     * Add LicitacaoContrato
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato
     * @return TipoGarantia
     */
    public function addFkLicitacaoContratos(\Urbem\CoreBundle\Entity\Licitacao\Contrato $fkLicitacaoContrato)
    {
        if (false === $this->fkLicitacaoContratos->contains($fkLicitacaoContrato)) {
            $fkLicitacaoContrato->setFkLicitacaoTipoGarantia($this);
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
}
