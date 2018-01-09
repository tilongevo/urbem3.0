<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * GrupoConcessaoValeTransporte
 */
class GrupoConcessaoValeTransporte
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var integer
     */
    private $codMes;

    /**
     * PK
     * @var integer
     */
    private $codConcessao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessao
     */
    private $fkBeneficioGrupoConcessao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    private $fkBeneficioConcessaoValeTransporte;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return GrupoConcessaoValeTransporte
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
     * Set codMes
     *
     * @param integer $codMes
     * @return GrupoConcessaoValeTransporte
     */
    public function setCodMes($codMes)
    {
        $this->codMes = $codMes;
        return $this;
    }

    /**
     * Get codMes
     *
     * @return integer
     */
    public function getCodMes()
    {
        return $this->codMes;
    }

    /**
     * Set codConcessao
     *
     * @param integer $codConcessao
     * @return GrupoConcessaoValeTransporte
     */
    public function setCodConcessao($codConcessao)
    {
        $this->codConcessao = $codConcessao;
        return $this;
    }

    /**
     * Get codConcessao
     *
     * @return integer
     */
    public function getCodConcessao()
    {
        return $this->codConcessao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return GrupoConcessaoValeTransporte
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
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return GrupoConcessaoValeTransporte
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioGrupoConcessao
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessao $fkBeneficioGrupoConcessao
     * @return GrupoConcessaoValeTransporte
     */
    public function setFkBeneficioGrupoConcessao(\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessao $fkBeneficioGrupoConcessao)
    {
        $this->codGrupo = $fkBeneficioGrupoConcessao->getCodGrupo();
        $this->fkBeneficioGrupoConcessao = $fkBeneficioGrupoConcessao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioGrupoConcessao
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessao
     */
    public function getFkBeneficioGrupoConcessao()
    {
        return $this->fkBeneficioGrupoConcessao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     * @return GrupoConcessaoValeTransporte
     */
    public function setFkBeneficioConcessaoValeTransporte(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte)
    {
        $this->codConcessao = $fkBeneficioConcessaoValeTransporte->getCodConcessao();
        $this->codMes = $fkBeneficioConcessaoValeTransporte->getCodMes();
        $this->exercicio = $fkBeneficioConcessaoValeTransporte->getExercicio();
        $this->fkBeneficioConcessaoValeTransporte = $fkBeneficioConcessaoValeTransporte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioConcessaoValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    public function getFkBeneficioConcessaoValeTransporte()
    {
        return $this->fkBeneficioConcessaoValeTransporte;
    }
}
