<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * ProgramaSocial
 */
class ProgramaSocial
{
    /**
     * PK
     * @var integer
     */
    private $codPrograma;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $nomPrograma;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Cse\Municipal
     */
    private $fkCseMunicipal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Cse\Estadual
     */
    private $fkCseEstadual;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Cse\Federal
     */
    private $fkCseFederal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\CidadaoPrograma
     */
    private $fkCseCidadaoProgramas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCseCidadaoProgramas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return ProgramaSocial
     */
    public function setCodPrograma($codPrograma)
    {
        $this->codPrograma = $codPrograma;
        return $this;
    }

    /**
     * Get codPrograma
     *
     * @return integer
     */
    public function getCodPrograma()
    {
        return $this->codPrograma;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ProgramaSocial
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
     * Set nomPrograma
     *
     * @param string $nomPrograma
     * @return ProgramaSocial
     */
    public function setNomPrograma($nomPrograma)
    {
        $this->nomPrograma = $nomPrograma;
        return $this;
    }

    /**
     * Get nomPrograma
     *
     * @return string
     */
    public function getNomPrograma()
    {
        return $this->nomPrograma;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ProgramaSocial
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
     * Add CseCidadaoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoPrograma $fkCseCidadaoPrograma
     * @return ProgramaSocial
     */
    public function addFkCseCidadaoProgramas(\Urbem\CoreBundle\Entity\Cse\CidadaoPrograma $fkCseCidadaoPrograma)
    {
        if (false === $this->fkCseCidadaoProgramas->contains($fkCseCidadaoPrograma)) {
            $fkCseCidadaoPrograma->setFkCseProgramaSocial($this);
            $this->fkCseCidadaoProgramas->add($fkCseCidadaoPrograma);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CseCidadaoPrograma
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoPrograma $fkCseCidadaoPrograma
     */
    public function removeFkCseCidadaoProgramas(\Urbem\CoreBundle\Entity\Cse\CidadaoPrograma $fkCseCidadaoPrograma)
    {
        $this->fkCseCidadaoProgramas->removeElement($fkCseCidadaoPrograma);
    }

    /**
     * OneToMany (owning side)
     * Get fkCseCidadaoProgramas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cse\CidadaoPrograma
     */
    public function getFkCseCidadaoProgramas()
    {
        return $this->fkCseCidadaoProgramas;
    }

    /**
     * OneToOne (inverse side)
     * Set CseMunicipal
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Municipal $fkCseMunicipal
     * @return ProgramaSocial
     */
    public function setFkCseMunicipal(\Urbem\CoreBundle\Entity\Cse\Municipal $fkCseMunicipal)
    {
        $fkCseMunicipal->setFkCseProgramaSocial($this);
        $this->fkCseMunicipal = $fkCseMunicipal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkCseMunicipal
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Municipal
     */
    public function getFkCseMunicipal()
    {
        return $this->fkCseMunicipal;
    }

    /**
     * OneToOne (inverse side)
     * Set CseEstadual
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Estadual $fkCseEstadual
     * @return ProgramaSocial
     */
    public function setFkCseEstadual(\Urbem\CoreBundle\Entity\Cse\Estadual $fkCseEstadual)
    {
        $fkCseEstadual->setFkCseProgramaSocial($this);
        $this->fkCseEstadual = $fkCseEstadual;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkCseEstadual
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Estadual
     */
    public function getFkCseEstadual()
    {
        return $this->fkCseEstadual;
    }

    /**
     * OneToOne (inverse side)
     * Set CseFederal
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Federal $fkCseFederal
     * @return ProgramaSocial
     */
    public function setFkCseFederal(\Urbem\CoreBundle\Entity\Cse\Federal $fkCseFederal)
    {
        $fkCseFederal->setFkCseProgramaSocial($this);
        $this->fkCseFederal = $fkCseFederal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkCseFederal
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Federal
     */
    public function getFkCseFederal()
    {
        return $this->fkCseFederal;
    }
}
