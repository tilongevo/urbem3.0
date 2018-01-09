<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * IdentificadorRiscoFiscal
 */
class IdentificadorRiscoFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codIdentificador;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\RiscosFiscais
     */
    private $fkStnRiscosFiscais;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkStnRiscosFiscais = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codIdentificador
     *
     * @param integer $codIdentificador
     * @return IdentificadorRiscoFiscal
     */
    public function setCodIdentificador($codIdentificador)
    {
        $this->codIdentificador = $codIdentificador;
        return $this;
    }

    /**
     * Get codIdentificador
     *
     * @return integer
     */
    public function getCodIdentificador()
    {
        return $this->codIdentificador;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return IdentificadorRiscoFiscal
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
     * Add StnRiscosFiscais
     *
     * @param \Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais
     * @return IdentificadorRiscoFiscal
     */
    public function addFkStnRiscosFiscais(\Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais)
    {
        if (false === $this->fkStnRiscosFiscais->contains($fkStnRiscosFiscais)) {
            $fkStnRiscosFiscais->setFkStnIdentificadorRiscoFiscal($this);
            $this->fkStnRiscosFiscais->add($fkStnRiscosFiscais);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnRiscosFiscais
     *
     * @param \Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais
     */
    public function removeFkStnRiscosFiscais(\Urbem\CoreBundle\Entity\Stn\RiscosFiscais $fkStnRiscosFiscais)
    {
        $this->fkStnRiscosFiscais->removeElement($fkStnRiscosFiscais);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnRiscosFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\RiscosFiscais
     */
    public function getFkStnRiscosFiscais()
    {
        return $this->fkStnRiscosFiscais;
    }
}
