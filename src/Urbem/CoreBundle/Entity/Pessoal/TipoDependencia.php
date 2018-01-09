<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoDependencia
 */
class TipoDependencia
{
    /**
     * PK
     * @var integer
     */
    private $codDependencia;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    private $fkPessoalContratoPensionistas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoPensionistas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDependencia
     *
     * @param integer $codDependencia
     * @return TipoDependencia
     */
    public function setCodDependencia($codDependencia)
    {
        $this->codDependencia = $codDependencia;
        return $this;
    }

    /**
     * Get codDependencia
     *
     * @return integer
     */
    public function getCodDependencia()
    {
        return $this->codDependencia;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDependencia
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
     * Add PessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     * @return TipoDependencia
     */
    public function addFkPessoalContratoPensionistas(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        if (false === $this->fkPessoalContratoPensionistas->contains($fkPessoalContratoPensionista)) {
            $fkPessoalContratoPensionista->setFkPessoalTipoDependencia($this);
            $this->fkPessoalContratoPensionistas->add($fkPessoalContratoPensionista);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista
     */
    public function removeFkPessoalContratoPensionistas(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista $fkPessoalContratoPensionista)
    {
        $this->fkPessoalContratoPensionistas->removeElement($fkPessoalContratoPensionista);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista
     */
    public function getFkPessoalContratoPensionistas()
    {
        return $this->fkPessoalContratoPensionistas;
    }
}
