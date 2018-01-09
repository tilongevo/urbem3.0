<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * VencimentoParcela
 */
class VencimentoParcela
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
    private $codParcela;

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
     * @var \DateTime
     */
    private $dataVencimentoDesconto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento
     */
    private $fkArrecadacaoGrupoVencimento;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return VencimentoParcela
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
     * @return VencimentoParcela
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
     * Set codParcela
     *
     * @param integer $codParcela
     * @return VencimentoParcela
     */
    public function setCodParcela($codParcela)
    {
        $this->codParcela = $codParcela;
        return $this;
    }

    /**
     * Get codParcela
     *
     * @return integer
     */
    public function getCodParcela()
    {
        return $this->codParcela;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return VencimentoParcela
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
     * @return VencimentoParcela
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
     * @return VencimentoParcela
     */
    public function setValor($valor = null)
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
     * @return VencimentoParcela
     */
    public function setPercentual($percentual = null)
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
     * Set dataVencimentoDesconto
     *
     * @param \DateTime $dataVencimentoDesconto
     * @return VencimentoParcela
     */
    public function setDataVencimentoDesconto(\DateTime $dataVencimentoDesconto = null)
    {
        $this->dataVencimentoDesconto = $dataVencimentoDesconto;
        return $this;
    }

    /**
     * Get dataVencimentoDesconto
     *
     * @return \DateTime
     */
    public function getDataVencimentoDesconto()
    {
        return $this->dataVencimentoDesconto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoGrupoVencimento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento $fkArrecadacaoGrupoVencimento
     * @return VencimentoParcela
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
