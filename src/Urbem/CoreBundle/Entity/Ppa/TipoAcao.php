<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * TipoAcao
 */
class TipoAcao
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    private $fkPpaAcaoDados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaAcaoDados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoAcao
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoAcao
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
     * Add PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     * @return TipoAcao
     */
    public function addFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        if (false === $this->fkPpaAcaoDados->contains($fkPpaAcaoDados)) {
            $fkPpaAcaoDados->setFkPpaTipoAcao($this);
            $this->fkPpaAcaoDados->add($fkPpaAcaoDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaAcaoDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados
     */
    public function removeFkPpaAcaoDados(\Urbem\CoreBundle\Entity\Ppa\AcaoDados $fkPpaAcaoDados)
    {
        $this->fkPpaAcaoDados->removeElement($fkPpaAcaoDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaAcaoDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\AcaoDados
     */
    public function getFkPpaAcaoDados()
    {
        return $this->fkPpaAcaoDados;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->descricao;
    }
}
