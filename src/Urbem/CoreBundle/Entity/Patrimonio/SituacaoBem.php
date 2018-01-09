<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * SituacaoBem
 */
class SituacaoBem
{
    /**
     * PK
     * @var integer
     */
    private $codSituacao;

    /**
     * @var string
     */
    private $nomSituacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    private $fkPatrimonioInventarioHistoricoBens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    private $fkPatrimonioHistoricoBens;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioInventarioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPatrimonioHistoricoBens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return SituacaoBem
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set nomSituacao
     *
     * @param string $nomSituacao
     * @return SituacaoBem
     */
    public function setNomSituacao($nomSituacao)
    {
        $this->nomSituacao = $nomSituacao;
        return $this;
    }

    /**
     * Get nomSituacao
     *
     * @return string
     */
    public function getNomSituacao()
    {
        return $this->nomSituacao;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     * @return SituacaoBem
     */
    public function addFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        if (false === $this->fkPatrimonioInventarioHistoricoBens->contains($fkPatrimonioInventarioHistoricoBem)) {
            $fkPatrimonioInventarioHistoricoBem->setFkPatrimonioSituacaoBem($this);
            $this->fkPatrimonioInventarioHistoricoBens->add($fkPatrimonioInventarioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioInventarioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem
     */
    public function removeFkPatrimonioInventarioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem $fkPatrimonioInventarioHistoricoBem)
    {
        $this->fkPatrimonioInventarioHistoricoBens->removeElement($fkPatrimonioInventarioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioInventarioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem
     */
    public function getFkPatrimonioInventarioHistoricoBens()
    {
        return $this->fkPatrimonioInventarioHistoricoBens;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     * @return SituacaoBem
     */
    public function addFkPatrimonioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        if (false === $this->fkPatrimonioHistoricoBens->contains($fkPatrimonioHistoricoBem)) {
            $fkPatrimonioHistoricoBem->setFkPatrimonioSituacaoBem($this);
            $this->fkPatrimonioHistoricoBens->add($fkPatrimonioHistoricoBem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     */
    public function removeFkPatrimonioHistoricoBens(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        $this->fkPatrimonioHistoricoBens->removeElement($fkPatrimonioHistoricoBem);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioHistoricoBens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    public function getFkPatrimonioHistoricoBens()
    {
        return $this->fkPatrimonioHistoricoBens;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->fkPatrimonioInventarioHistoricoBens)) {
            return (string) $this->nomSituacao;
        }
        return 'Situação';
    }
}
