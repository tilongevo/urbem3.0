<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * AporteRecursoRpps
 */
class AporteRecursoRpps
{
    /**
     * PK
     * @var integer
     */
    private $codAporte;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codGrupo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita
     */
    private $fkStnAporteRecursoRppsReceitas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsGrupo
     */
    private $fkStnAporteRecursoRppsGrupo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkStnAporteRecursoRppsReceitas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAporte
     *
     * @param integer $codAporte
     * @return AporteRecursoRpps
     */
    public function setCodAporte($codAporte)
    {
        $this->codAporte = $codAporte;
        return $this;
    }

    /**
     * Get codAporte
     *
     * @return integer
     */
    public function getCodAporte()
    {
        return $this->codAporte;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return AporteRecursoRpps
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
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return AporteRecursoRpps
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
     * Set descricao
     *
     * @param string $descricao
     * @return AporteRecursoRpps
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
     * Add StnAporteRecursoRppsReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita $fkStnAporteRecursoRppsReceita
     * @return AporteRecursoRpps
     */
    public function addFkStnAporteRecursoRppsReceitas(\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita $fkStnAporteRecursoRppsReceita)
    {
        if (false === $this->fkStnAporteRecursoRppsReceitas->contains($fkStnAporteRecursoRppsReceita)) {
            $fkStnAporteRecursoRppsReceita->setFkStnAporteRecursoRpps($this);
            $this->fkStnAporteRecursoRppsReceitas->add($fkStnAporteRecursoRppsReceita);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnAporteRecursoRppsReceita
     *
     * @param \Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita $fkStnAporteRecursoRppsReceita
     */
    public function removeFkStnAporteRecursoRppsReceitas(\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita $fkStnAporteRecursoRppsReceita)
    {
        $this->fkStnAporteRecursoRppsReceitas->removeElement($fkStnAporteRecursoRppsReceita);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnAporteRecursoRppsReceitas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsReceita
     */
    public function getFkStnAporteRecursoRppsReceitas()
    {
        return $this->fkStnAporteRecursoRppsReceitas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkStnAporteRecursoRppsGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsGrupo $fkStnAporteRecursoRppsGrupo
     * @return AporteRecursoRpps
     */
    public function setFkStnAporteRecursoRppsGrupo(\Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsGrupo $fkStnAporteRecursoRppsGrupo)
    {
        $this->codGrupo = $fkStnAporteRecursoRppsGrupo->getCodGrupo();
        $this->exercicio = $fkStnAporteRecursoRppsGrupo->getExercicio();
        $this->fkStnAporteRecursoRppsGrupo = $fkStnAporteRecursoRppsGrupo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkStnAporteRecursoRppsGrupo
     *
     * @return \Urbem\CoreBundle\Entity\Stn\AporteRecursoRppsGrupo
     */
    public function getFkStnAporteRecursoRppsGrupo()
    {
        return $this->fkStnAporteRecursoRppsGrupo;
    }
}
