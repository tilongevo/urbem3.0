<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * VinculoStnRecurso
 */
class VinculoStnRecurso
{
    const COD_VINCULO_OPERACOES_DE_CREDITO = 4;

    /**
     * PK
     * @var integer
     */
    private $codVinculo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoRecurso
     */
    private $fkStnVinculoRecursos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkStnVinculoRecursos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codVinculo
     *
     * @param integer $codVinculo
     * @return VinculoStnRecurso
     */
    public function setCodVinculo($codVinculo)
    {
        $this->codVinculo = $codVinculo;
        return $this;
    }

    /**
     * Get codVinculo
     *
     * @return integer
     */
    public function getCodVinculo()
    {
        return $this->codVinculo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return VinculoStnRecurso
     */
    public function setDescricao($descricao = null)
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
     * Add StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     * @return VinculoStnRecurso
     */
    public function addFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        if (false === $this->fkStnVinculoRecursos->contains($fkStnVinculoRecurso)) {
            $fkStnVinculoRecurso->setFkStnVinculoStnRecurso($this);
            $this->fkStnVinculoRecursos->add($fkStnVinculoRecurso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     */
    public function removeFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        $this->fkStnVinculoRecursos->removeElement($fkStnVinculoRecurso);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnVinculoRecursos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\VinculoRecurso
     */
    public function getFkStnVinculoRecursos()
    {
        return $this->fkStnVinculoRecursos;
    }
}
