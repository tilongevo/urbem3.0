<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CalculoGrupoCredito
 */
class CalculoGrupoCredito
{
    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * @var integer
     */
    private $codGrupo;

    /**
     * @var string
     */
    private $anoExercicio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    private $fkArrecadacaoGrupoCredito;


    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return CalculoGrupoCredito
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return CalculoGrupoCredito
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
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return CalculoGrupoCredito
     */
    public function setAnoExercicio($anoExercicio = null)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito
     * @return CalculoGrupoCredito
     */
    public function setFkArrecadacaoGrupoCredito(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito)
    {
        $this->codGrupo = $fkArrecadacaoGrupoCredito->getCodGrupo();
        $this->anoExercicio = $fkArrecadacaoGrupoCredito->getAnoExercicio();
        $this->fkArrecadacaoGrupoCredito = $fkArrecadacaoGrupoCredito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoGrupoCredito
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    public function getFkArrecadacaoGrupoCredito()
    {
        return $this->fkArrecadacaoGrupoCredito;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return CalculoGrupoCredito
     */
    public function setFkArrecadacaoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoCalculo->getCodCalculo();
        $this->fkArrecadacaoCalculo = $fkArrecadacaoCalculo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculo()
    {
        return $this->fkArrecadacaoCalculo;
    }
}
