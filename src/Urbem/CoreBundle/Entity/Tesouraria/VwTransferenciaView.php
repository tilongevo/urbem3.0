<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * VwTransferenciaView
 */
class VwTransferenciaView
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $nomEntidade;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var integer
     */
    private $codBoletim;

    /**
     * @var string
     */
    private $dtBoletim;

    /**
     * @var integer
     */
    private $codHistorico;

    /**
     * @var string
     */
    private $dtTransferencia;

    /**
     * @var \DateTime
     */
    private $timestampTransferencia;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $codPlanoCredito;

    /**
     * @var string
     */
    private $nomContaCredito;

    /**
     * @var integer
     */
    private $codPlanoDebito;

    /**
     * @var string
     */
    private $nomContaDebito;

    /**
     * @var integer
     */
    private $valor;

    /**
     * @var integer
     */
    private $valorEstornado;

    /**
     * @var integer
     */
    private $codRecibo;

    /**
     * @var integer
     */
    private $codRecurso;

    /**
     * @var string
     */
    private $mascRecursoRed;

    /**
     * @var string
     */
    private $nomRecurso;

    /**
     * @var string
     */
    private $recurso;

    /**
     * @var integer
     */
    private $codCredor;

    /**
     * @var string
     */
    private $nomCredor;

    /**
     * @var integer
     */
    private $codTipo;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return VwTransferencia
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return VwTransferencia
     */
    public function setExercicio($exercicio = null)
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return VwTransferencia
     */
    public function setCodEntidade($codEntidade = null)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set nomEntidade
     *
     * @param string $nomEntidade
     * @return VwTransferencia
     */
    public function setNomEntidade($nomEntidade = null)
    {
        $this->nomEntidade = $nomEntidade;
        return $this;
    }

    /**
     * Get nomEntidade
     *
     * @return string
     */
    public function getNomEntidade()
    {
        return $this->nomEntidade;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return VwTransferencia
     */
    public function setTipo($tipo = null)
    {
        $this->tipo = $tipo;
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set codBoletim
     *
     * @param integer $codBoletim
     * @return VwTransferencia
     */
    public function setCodBoletim($codBoletim = null)
    {
        $this->codBoletim = $codBoletim;
        return $this;
    }

    /**
     * Get codBoletim
     *
     * @return integer
     */
    public function getCodBoletim()
    {
        return $this->codBoletim;
    }

    /**
     * Set dtBoletim
     *
     * @param string $dtBoletim
     * @return VwTransferencia
     */
    public function setDtBoletim($dtBoletim = null)
    {
        $this->dtBoletim = $dtBoletim;
        return $this;
    }

    /**
     * Get dtBoletim
     *
     * @return string
     */
    public function getDtBoletim()
    {
        return $this->dtBoletim;
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return VwTransferencia
     */
    public function setCodHistorico($codHistorico = null)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set dtTransferencia
     *
     * @param string $dtTransferencia
     * @return VwTransferencia
     */
    public function setDtTransferencia($dtTransferencia = null)
    {
        $this->dtTransferencia = $dtTransferencia;
        return $this;
    }

    /**
     * Get dtTransferencia
     *
     * @return string
     */
    public function getDtTransferencia()
    {
        return $this->dtTransferencia;
    }

    /**
     * Set timestampTransferencia
     *
     * @param \DateTime $timestampTransferencia
     * @return VwTransferencia
     */
    public function setTimestampTransferencia(\DateTime $timestampTransferencia = null)
    {
        $this->timestampTransferencia = $timestampTransferencia;
        return $this;
    }

    /**
     * Get timestampTransferencia
     *
     * @return \DateTime
     */
    public function getTimestampTransferencia()
    {
        return $this->timestampTransferencia;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return VwTransferencia
     */
    public function setObservacao($observacao = null)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set codPlanoCredito
     *
     * @param integer $codPlanoCredito
     * @return VwTransferencia
     */
    public function setCodPlanoCredito($codPlanoCredito = null)
    {
        $this->codPlanoCredito = $codPlanoCredito;
        return $this;
    }

    /**
     * Get codPlanoCredito
     *
     * @return integer
     */
    public function getCodPlanoCredito()
    {
        return $this->codPlanoCredito;
    }

    /**
     * @return string
     */
    public function getPlanoCredito()
    {
        return sprintf('%s - %s', $this->codPlanoCredito, $this->nomContaCredito);
    }

    /**
     * Set nomContaCredito
     *
     * @param string $nomContaCredito
     * @return VwTransferencia
     */
    public function setNomContaCredito($nomContaCredito = null)
    {
        $this->nomContaCredito = $nomContaCredito;
        return $this;
    }

    /**
     * Get nomContaCredito
     *
     * @return string
     */
    public function getNomContaCredito()
    {
        return $this->nomContaCredito;
    }

    /**
     * Set codPlanoDebito
     *
     * @param integer $codPlanoDebito
     * @return VwTransferencia
     */
    public function setCodPlanoDebito($codPlanoDebito = null)
    {
        $this->codPlanoDebito = $codPlanoDebito;
        return $this;
    }

    /**
     * Get codPlanoDebito
     *
     * @return integer
     */
    public function getCodPlanoDebito()
    {
        return $this->codPlanoDebito;
    }

    /**
     * @return string
     */
    public function getPlanoDebito()
    {
        return sprintf('%s - %s', $this->codPlanoDebito, $this->nomContaDebito);
    }

    /**
     * Set nomContaDebito
     *
     * @param string $nomContaDebito
     * @return VwTransferencia
     */
    public function setNomContaDebito($nomContaDebito = null)
    {
        $this->nomContaDebito = $nomContaDebito;
        return $this;
    }

    /**
     * Get nomContaDebito
     *
     * @return string
     */
    public function getNomContaDebito()
    {
        return $this->nomContaDebito;
    }

    /**
     * Set valor
     *
     * @param integer $valor
     * @return VwTransferencia
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
     * Set valorEstornado
     *
     * @param integer $valorEstornado
     * @return VwTransferencia
     */
    public function setValorEstornado($valorEstornado = null)
    {
        $this->valorEstornado = $valorEstornado;
        return $this;
    }

    /**
     * Get valorEstornado
     *
     * @return integer
     */
    public function getValorEstornado()
    {
        return $this->valorEstornado;
    }

    /**
     * Set codRecibo
     *
     * @param integer $codRecibo
     * @return VwTransferencia
     */
    public function setCodRecibo($codRecibo = null)
    {
        $this->codRecibo = $codRecibo;
        return $this;
    }

    /**
     * Get codRecibo
     *
     * @return integer
     */
    public function getCodRecibo()
    {
        return $this->codRecibo;
    }

    /**
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return VwTransferencia
     */
    public function setCodRecurso($codRecurso = null)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * Set mascRecursoRed
     *
     * @param string $mascRecursoRed
     * @return VwTransferencia
     */
    public function setMascRecursoRed($mascRecursoRed = null)
    {
        $this->mascRecursoRed = $mascRecursoRed;
        return $this;
    }

    /**
     * Get mascRecursoRed
     *
     * @return string
     */
    public function getMascRecursoRed()
    {
        return $this->mascRecursoRed;
    }

    /**
     * Set nomRecurso
     *
     * @param string $nomRecurso
     * @return VwTransferencia
     */
    public function setNomRecurso($nomRecurso = null)
    {
        $this->nomRecurso = $nomRecurso;
        return $this;
    }

    /**
     * Get nomRecurso
     *
     * @return string
     */
    public function getNomRecurso()
    {
        return $this->nomRecurso;
    }

    /**
     * Set recurso
     *
     * @param string $recurso
     * @return VwTransferencia
     */
    public function setRecurso($recurso = null)
    {
        $this->recurso = $recurso;
        return $this;
    }

    /**
     * Get recurso
     *
     * @return string
     */
    public function getRecurso()
    {
        return $this->recurso;
    }

    /**
     * Set codCredor
     *
     * @param integer $codCredor
     * @return VwTransferencia
     */
    public function setCodCredor($codCredor = null)
    {
        $this->codCredor = $codCredor;
        return $this;
    }

    /**
     * Get codCredor
     *
     * @return integer
     */
    public function getCodCredor()
    {
        return $this->codCredor;
    }

    /**
     * Set nomCredor
     *
     * @param string $nomCredor
     * @return VwTransferencia
     */
    public function setNomCredor($nomCredor = null)
    {
        $this->nomCredor = $nomCredor;
        return $this;
    }

    /**
     * Get nomCredor
     *
     * @return string
     */
    public function getNomCredor()
    {
        return $this->nomCredor;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return VwTransferencia
     */
    public function setCodTipo($codTipo = null)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->getNomEntidade());
    }
}
