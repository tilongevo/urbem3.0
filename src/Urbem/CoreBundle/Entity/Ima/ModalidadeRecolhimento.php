<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ModalidadeRecolhimento
 */
class ModalidadeRecolhimento
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $sefip;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CategoriaSefip
     */
    private $fkImaCategoriaSefips;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaCategoriaSefips = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return ModalidadeRecolhimento
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ModalidadeRecolhimento
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
     * Set sefip
     *
     * @param string $sefip
     * @return ModalidadeRecolhimento
     */
    public function setSefip($sefip)
    {
        $this->sefip = $sefip;
        return $this;
    }

    /**
     * Get sefip
     *
     * @return string
     */
    public function getSefip()
    {
        return $this->sefip;
    }

    /**
     * OneToMany (owning side)
     * Add ImaCategoriaSefip
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CategoriaSefip $fkImaCategoriaSefip
     * @return ModalidadeRecolhimento
     */
    public function addFkImaCategoriaSefips(\Urbem\CoreBundle\Entity\Ima\CategoriaSefip $fkImaCategoriaSefip)
    {
        if (false === $this->fkImaCategoriaSefips->contains($fkImaCategoriaSefip)) {
            $fkImaCategoriaSefip->setFkImaModalidadeRecolhimento($this);
            $this->fkImaCategoriaSefips->add($fkImaCategoriaSefip);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaCategoriaSefip
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CategoriaSefip $fkImaCategoriaSefip
     */
    public function removeFkImaCategoriaSefips(\Urbem\CoreBundle\Entity\Ima\CategoriaSefip $fkImaCategoriaSefip)
    {
        $this->fkImaCategoriaSefips->removeElement($fkImaCategoriaSefip);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaCategoriaSefips
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CategoriaSefip
     */
    public function getFkImaCategoriaSefips()
    {
        return $this->fkImaCategoriaSefips;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codModalidade, $this->descricao);
    }
}
