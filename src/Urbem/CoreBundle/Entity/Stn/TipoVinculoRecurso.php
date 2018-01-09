<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * TipoVinculoRecurso
 */
class TipoVinculoRecurso
{
    const COD_TIPO_RECURSOS_OUTRAS_DESPESAS = 2;

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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoVinculoRecurso
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
     * @return TipoVinculoRecurso
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
     * Add StnVinculoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso
     * @return TipoVinculoRecurso
     */
    public function addFkStnVinculoRecursos(\Urbem\CoreBundle\Entity\Stn\VinculoRecurso $fkStnVinculoRecurso)
    {
        if (false === $this->fkStnVinculoRecursos->contains($fkStnVinculoRecurso)) {
            $fkStnVinculoRecurso->setFkStnTipoVinculoRecurso($this);
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
