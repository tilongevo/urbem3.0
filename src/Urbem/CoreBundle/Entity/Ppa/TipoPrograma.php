<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * TipoPrograma
 */
class TipoPrograma
{
    /**
     * PK
     * @var integer
     */
    private $codTipoPrograma;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    private $fkPpaProgramaDados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaProgramaDados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoPrograma
     *
     * @param integer $codTipoPrograma
     * @return TipoPrograma
     */
    public function setCodTipoPrograma($codTipoPrograma)
    {
        $this->codTipoPrograma = $codTipoPrograma;
        return $this;
    }

    /**
     * Get codTipoPrograma
     *
     * @return integer
     */
    public function getCodTipoPrograma()
    {
        return $this->codTipoPrograma;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoPrograma
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
     * Add PpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     * @return TipoPrograma
     */
    public function addFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        if (false === $this->fkPpaProgramaDados->contains($fkPpaProgramaDados)) {
            $fkPpaProgramaDados->setFkPpaTipoPrograma($this);
            $this->fkPpaProgramaDados->add($fkPpaProgramaDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaDados
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados
     */
    public function removeFkPpaProgramaDados(\Urbem\CoreBundle\Entity\Ppa\ProgramaDados $fkPpaProgramaDados)
    {
        $this->fkPpaProgramaDados->removeElement($fkPpaProgramaDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaDados
     */
    public function getFkPpaProgramaDados()
    {
        return $this->fkPpaProgramaDados;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codTipoPrograma, $this->descricao);
    }
}
