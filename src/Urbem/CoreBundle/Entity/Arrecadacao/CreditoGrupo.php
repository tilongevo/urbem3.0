<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CreditoGrupo
 */
class CreditoGrupo
{
    /**
     * PK
     * @var integer
     */
    private $codCredito;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var integer
     */
    private $codGenero;

    /**
     * PK
     * @var integer
     */
    private $codEspecie;

    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var boolean
     */
    private $desconto = false;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCredito;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    private $fkArrecadacaoGrupoCredito;


    /**
     * Set codCredito
     *
     * @param integer $codCredito
     * @return CreditoGrupo
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
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return CreditoGrupo
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
     * Set codGenero
     *
     * @param integer $codGenero
     * @return CreditoGrupo
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
     * Set codEspecie
     *
     * @param integer $codEspecie
     * @return CreditoGrupo
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
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return CreditoGrupo
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
     * @return CreditoGrupo
     */
    public function setAnoExercicio($anoExercicio)
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
     * Set desconto
     *
     * @param boolean $desconto
     * @return CreditoGrupo
     */
    public function setDesconto($desconto = null)
    {
        $this->desconto = $desconto;
        return $this;
    }

    /**
     * Get desconto
     *
     * @return boolean
     */
    public function getDesconto()
    {
        return $this->desconto;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return CreditoGrupo
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return CreditoGrupo
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

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito
     * @return CreditoGrupo
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
}
