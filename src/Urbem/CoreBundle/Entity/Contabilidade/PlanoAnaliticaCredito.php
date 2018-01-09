<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * PlanoAnaliticaCredito
 */
class PlanoAnaliticaCredito
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codCredito;

    /**
     * @var integer
     */
    private $codPlano;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return PlanoAnaliticaCredito
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
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return PlanoAnaliticaCredito
     */
    public function setCodEspecie($codEspecie)
    {
        $this->codEspecie = $codEspecie;
        return $this;
    }

    /**
     * Get codEspecie
     *
     * @return integer
     */
    public function getCodEspecie()
    {
        return $this->codEspecie;
    }

    /**
     * Set codGenero
     *
     * @param integer $codGenero
     * @return PlanoAnaliticaCredito
     */
    public function setCodGenero($codGenero)
    {
        $this->codGenero = $codGenero;
        return $this;
    }

    /**
     * Get codGenero
     *
     * @return integer
     */
    public function getCodGenero()
    {
        return $this->codGenero;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return PlanoAnaliticaCredito
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return PlanoAnaliticaCredito
     */
    public function setCodCredito($codCredito)
    {
        $this->codCredito = $codCredito;
        return $this;
    }

    /**
     * Get codCredito
     *
     * @return integer
     */
    public function getCodCredito()
    {
        return $this->codCredito;
    }

    /**
     * Set codPlano
     *
     * @param integer $codPlano
     * @return PlanoAnaliticaCredito
     */
    public function setCodPlano($codPlano)
    {
        $this->codPlano = $codPlano;
        return $this;
    }

    /**
     * Get codPlano
     *
     * @return integer
     */
    public function getCodPlano()
    {
        return $this->codPlano;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return PlanoAnaliticaCredito
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlano = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return PlanoAnaliticaCredito
     */
    public function setFkMonetarioCredito(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        $this->codCredito = $fkMonetarioCredito->getCodCredito();
        $this->codNatureza = $fkMonetarioCredito->getCodNatureza();
        $this->codGenero = $fkMonetarioCredito->getCodGenero();
        $this->codEspecie = $fkMonetarioCredito->getCodEspecie();
        $this->fkMonetarioCredito = $fkMonetarioCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioCredito
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCredito()
    {
        return $this->fkMonetarioCredito;
    }
}
