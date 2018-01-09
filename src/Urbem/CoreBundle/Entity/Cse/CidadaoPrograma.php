<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * CidadaoPrograma
 */
class CidadaoPrograma
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
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * @var \DateTime
     */
    private $dtInclusao;

    /**
     * @var integer
     */
    private $vlBeneficio;

    /**
     * @var boolean
     */
    private $prioritario = false;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\ProgramaSocial
     */
    private $fkCseProgramaSocial;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadao;


    /**
     * Set codPrograma
     *
     * @param integer $codPrograma
     * @return CidadaoPrograma
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
     * @return CidadaoPrograma
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
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return CidadaoPrograma
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set dtInclusao
     *
     * @param \DateTime $dtInclusao
     * @return CidadaoPrograma
     */
    public function setDtInclusao(\DateTime $dtInclusao)
    {
        $this->dtInclusao = $dtInclusao;
        return $this;
    }

    /**
     * Get dtInclusao
     *
     * @return \DateTime
     */
    public function getDtInclusao()
    {
        return $this->dtInclusao;
    }

    /**
     * Set vlBeneficio
     *
     * @param integer $vlBeneficio
     * @return CidadaoPrograma
     */
    public function setVlBeneficio($vlBeneficio)
    {
        $this->vlBeneficio = $vlBeneficio;
        return $this;
    }

    /**
     * Get vlBeneficio
     *
     * @return integer
     */
    public function getVlBeneficio()
    {
        return $this->vlBeneficio;
    }

    /**
     * Set prioritario
     *
     * @param boolean $prioritario
     * @return CidadaoPrograma
     */
    public function setPrioritario($prioritario)
    {
        $this->prioritario = $prioritario;
        return $this;
    }

    /**
     * Get prioritario
     *
     * @return boolean
     */
    public function getPrioritario()
    {
        return $this->prioritario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseProgramaSocial
     *
     * @param \Urbem\CoreBundle\Entity\Cse\ProgramaSocial $fkCseProgramaSocial
     * @return CidadaoPrograma
     */
    public function setFkCseProgramaSocial(\Urbem\CoreBundle\Entity\Cse\ProgramaSocial $fkCseProgramaSocial)
    {
        $this->codPrograma = $fkCseProgramaSocial->getCodPrograma();
        $this->exercicio = $fkCseProgramaSocial->getExercicio();
        $this->fkCseProgramaSocial = $fkCseProgramaSocial;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseProgramaSocial
     *
     * @return \Urbem\CoreBundle\Entity\Cse\ProgramaSocial
     */
    public function getFkCseProgramaSocial()
    {
        return $this->fkCseProgramaSocial;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return CidadaoPrograma
     */
    public function setFkCseCidadao(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->codCidadao = $fkCseCidadao->getCodCidadao();
        $this->fkCseCidadao = $fkCseCidadao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseCidadao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadao()
    {
        return $this->fkCseCidadao;
    }
}
