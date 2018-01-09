<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * Desconto
 */
class Desconto
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
    private $codVencimento;

    /**
     * PK
     * @var integer
     */
    private $codDesconto;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var \DateTime
     */
    private $dataVencimento;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var boolean
     */
    private $percentual;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento
     */
    private $fkArrecadacaoGrupoVencimento;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return Desconto
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
     * Set codVencimento
     *
     * @param integer $codVencimento
     * @return Desconto
     */
    public function setCodVencimento($codVencimento)
    {
        $this->codVencimento = $codVencimento;
        return $this;
    }

    /**
     * Get codVencimento
     *
     * @return integer
     */
    public function getCodVencimento()
    {
        return $this->codVencimento;
    }

    /**
     * Set codDesconto
     *
     * @param integer $codDesconto
     * @return Desconto
     */
    public function setCodDesconto($codDesconto)
    {
        $this->codDesconto = $codDesconto;
        return $this;
    }

    /**
     * Get codDesconto
     *
     * @return integer
     */
    public function getCodDesconto()
    {
        return $this->codDesconto;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return Desconto
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
     * Set dataVencimento
     *
     * @param \DateTime $dataVencimento
     * @return Desconto
     */
    public function setDataVencimento(\DateTime $dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
        return $this;
    }

    /**
     * Get dataVencimento
     *
     * @return \DateTime
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return Desconto
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set percentual
     *
     * @param boolean $percentual
     * @return Desconto
     */
    public function setPercentual($percentual)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return boolean
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoGrupoVencimento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento $fkArrecadacaoGrupoVencimento
     * @return Desconto
     */
    public function setFkArrecadacaoGrupoVencimento(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento $fkArrecadacaoGrupoVencimento)
    {
        $this->codGrupo = $fkArrecadacaoGrupoVencimento->getCodGrupo();
        $this->codVencimento = $fkArrecadacaoGrupoVencimento->getCodVencimento();
        $this->anoExercicio = $fkArrecadacaoGrupoVencimento->getAnoExercicio();
        $this->fkArrecadacaoGrupoVencimento = $fkArrecadacaoGrupoVencimento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoGrupoVencimento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento
     */
    public function getFkArrecadacaoGrupoVencimento()
    {
        return $this->fkArrecadacaoGrupoVencimento;
    }
}
