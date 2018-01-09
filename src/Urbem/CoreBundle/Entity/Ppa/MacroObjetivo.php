<?php
 
namespace Urbem\CoreBundle\Entity\Ppa;

/**
 * MacroObjetivo
 */
class MacroObjetivo
{
    /**
     * PK
     * @var integer
     */
    private $codMacro;

    /**
     * @var integer
     */
    private $codPpa;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial
     */
    private $fkPpaProgramaSetoriais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    private $fkPpaPpa;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPpaProgramaSetoriais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codMacro
     *
     * @param integer $codMacro
     * @return MacroObjetivo
     */
    public function setCodMacro($codMacro)
    {
        $this->codMacro = $codMacro;
        return $this;
    }

    /**
     * Get codMacro
     *
     * @return integer
     */
    public function getCodMacro()
    {
        return $this->codMacro;
    }

    /**
     * Set codPpa
     *
     * @param integer $codPpa
     * @return MacroObjetivo
     */
    public function setCodPpa($codPpa)
    {
        $this->codPpa = $codPpa;
        return $this;
    }

    /**
     * Get codPpa
     *
     * @return integer
     */
    public function getCodPpa()
    {
        return $this->codPpa;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return MacroObjetivo
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return MacroObjetivo
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add PpaProgramaSetorial
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial $fkPpaProgramaSetorial
     * @return MacroObjetivo
     */
    public function addFkPpaProgramaSetoriais(\Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial $fkPpaProgramaSetorial)
    {
        if (false === $this->fkPpaProgramaSetoriais->contains($fkPpaProgramaSetorial)) {
            $fkPpaProgramaSetorial->setFkPpaMacroObjetivo($this);
            $this->fkPpaProgramaSetoriais->add($fkPpaProgramaSetorial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PpaProgramaSetorial
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial $fkPpaProgramaSetorial
     */
    public function removeFkPpaProgramaSetoriais(\Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial $fkPpaProgramaSetorial)
    {
        $this->fkPpaProgramaSetoriais->removeElement($fkPpaProgramaSetorial);
    }

    /**
     * OneToMany (owning side)
     * Get fkPpaProgramaSetoriais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ppa\ProgramaSetorial
     */
    public function getFkPpaProgramaSetoriais()
    {
        return $this->fkPpaProgramaSetoriais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPpaPpa
     *
     * @param \Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa
     * @return MacroObjetivo
     */
    public function setFkPpaPpa(\Urbem\CoreBundle\Entity\Ppa\Ppa $fkPpaPpa)
    {
        $this->codPpa = $fkPpaPpa->getCodPpa();
        $this->fkPpaPpa = $fkPpaPpa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPpaPpa
     *
     * @return \Urbem\CoreBundle\Entity\Ppa\Ppa
     */
    public function getFkPpaPpa()
    {
        return $this->fkPpaPpa;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codMacro, $this->descricao);
    }
}
