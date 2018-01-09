<?php
 
namespace Urbem\CoreBundle\Entity\Normas;

/**
 * Lei
 */
class Lei
{
    /**
     * PK
     * @var integer
     */
    private $codLei;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl
     */
    private $fkNormasNormaDetalheAis;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe
     */
    private $fkTcetoNormaDetalhes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkNormasNormaDetalheAis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcetoNormaDetalhes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLei
     *
     * @param integer $codLei
     * @return Lei
     */
    public function setCodLei($codLei)
    {
        $this->codLei = $codLei;
        return $this;
    }

    /**
     * Get codLei
     *
     * @return integer
     */
    public function getCodLei()
    {
        return $this->codLei;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Lei
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
     * Add NormasNormaDetalheAl
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl
     * @return Lei
     */
    public function addFkNormasNormaDetalheAis(\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl)
    {
        if (false === $this->fkNormasNormaDetalheAis->contains($fkNormasNormaDetalheAl)) {
            $fkNormasNormaDetalheAl->setFkNormasLei($this);
            $this->fkNormasNormaDetalheAis->add($fkNormasNormaDetalheAl);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove NormasNormaDetalheAl
     *
     * @param \Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl
     */
    public function removeFkNormasNormaDetalheAis(\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl $fkNormasNormaDetalheAl)
    {
        $this->fkNormasNormaDetalheAis->removeElement($fkNormasNormaDetalheAl);
    }

    /**
     * OneToMany (owning side)
     * Get fkNormasNormaDetalheAis
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Normas\NormaDetalheAl
     */
    public function getFkNormasNormaDetalheAis()
    {
        return $this->fkNormasNormaDetalheAis;
    }

    /**
     * OneToMany (owning side)
     * Add TcetoNormaDetalhe
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe
     * @return Lei
     */
    public function addFkTcetoNormaDetalhes(\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe)
    {
        if (false === $this->fkTcetoNormaDetalhes->contains($fkTcetoNormaDetalhe)) {
            $fkTcetoNormaDetalhe->setFkNormasLei($this);
            $this->fkTcetoNormaDetalhes->add($fkTcetoNormaDetalhe);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcetoNormaDetalhe
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe
     */
    public function removeFkTcetoNormaDetalhes(\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe $fkTcetoNormaDetalhe)
    {
        $this->fkTcetoNormaDetalhes->removeElement($fkTcetoNormaDetalhe);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcetoNormaDetalhes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tceto\NormaDetalhe
     */
    public function getFkTcetoNormaDetalhes()
    {
        return $this->fkTcetoNormaDetalhes;
    }
}
