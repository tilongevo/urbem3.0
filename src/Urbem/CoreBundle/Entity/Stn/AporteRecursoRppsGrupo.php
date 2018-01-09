<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * AporteRecursoRppsGrupo
 */
class AporteRecursoRppsGrupo
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps
     */
    private $fkStnAporteRecursoRpps;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkStnAporteRecursoRpps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return AporteRecursoRppsGrupo
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AporteRecursoRppsGrupo
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return AporteRecursoRppsGrupo
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
     * Add StnAporteRecursoRpps
     *
     * @param \Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps $fkStnAporteRecursoRpps
     * @return AporteRecursoRppsGrupo
     */
    public function addFkStnAporteRecursoRpps(\Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps $fkStnAporteRecursoRpps)
    {
        if (false === $this->fkStnAporteRecursoRpps->contains($fkStnAporteRecursoRpps)) {
            $fkStnAporteRecursoRpps->setFkStnAporteRecursoRppsGrupo($this);
            $this->fkStnAporteRecursoRpps->add($fkStnAporteRecursoRpps);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnAporteRecursoRpps
     *
     * @param \Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps $fkStnAporteRecursoRpps
     */
    public function removeFkStnAporteRecursoRpps(\Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps $fkStnAporteRecursoRpps)
    {
        $this->fkStnAporteRecursoRpps->removeElement($fkStnAporteRecursoRpps);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnAporteRecursoRpps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\AporteRecursoRpps
     */
    public function getFkStnAporteRecursoRpps()
    {
        return $this->fkStnAporteRecursoRpps;
    }
}
