<?php
 
namespace Urbem\CoreBundle\Entity\Ldo;

/**
 * Indicadores
 */
class Indicadores
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
    private $codTipoIndicador;

    /**
     * @var integer
     */
    private $indice;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ldo\TipoIndicadores
     */
    private $fkLdoTipoIndicadores;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Indicadores
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
     * Set codTipoIndicador
     *
     * @param integer $codTipoIndicador
     * @return Indicadores
     */
    public function setCodTipoIndicador($codTipoIndicador)
    {
        $this->codTipoIndicador = $codTipoIndicador;
        return $this;
    }

    /**
     * Get codTipoIndicador
     *
     * @return integer
     */
    public function getCodTipoIndicador()
    {
        return $this->codTipoIndicador;
    }

    /**
     * Set indice
     *
     * @param integer $indice
     * @return Indicadores
     */
    public function setIndice($indice)
    {
        $this->indice = $indice;
        return $this;
    }

    /**
     * Get indice
     *
     * @return integer
     */
    public function getIndice()
    {
        return $this->indice;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkLdoTipoIndicadores
     *
     * @param \Urbem\CoreBundle\Entity\Ldo\TipoIndicadores $fkLdoTipoIndicadores
     * @return Indicadores
     */
    public function setFkLdoTipoIndicadores(\Urbem\CoreBundle\Entity\Ldo\TipoIndicadores $fkLdoTipoIndicadores)
    {
        $this->codTipoIndicador = $fkLdoTipoIndicadores->getCodTipoIndicador();
        $this->fkLdoTipoIndicadores = $fkLdoTipoIndicadores;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkLdoTipoIndicadores
     *
     * @return \Urbem\CoreBundle\Entity\Ldo\TipoIndicadores
     */
    public function getFkLdoTipoIndicadores()
    {
        return $this->fkLdoTipoIndicadores;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) sprintf('%s/%s/%s', $this->exercicio, (!empty($this->fkLdoTipoIndicadores) ? $this->fkLdoTipoIndicadores->getDescricao() : ''), $this->indice);
    }
}
