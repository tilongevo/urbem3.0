<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * ConsistenciaContab
 */
class ConsistenciaContab
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var string
     */
    private $exercicioEmpenho;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var \DateTime
     */
    private $dtLote;

    /**
     * @var \DateTime
     */
    private $dtEmpenho;

    /**
     * @var string
     */
    private $tipo;

    /**
     * @var boolean
     */
    private $estorno;

    /**
     * @var integer
     */
    private $sequencia;

    /**
     * @var integer
     */
    private $vlLancamento;

    /**
     * @var string
     */
    private $complemento;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ConsistenciaContab
     */
    public function setCodEmpenho($codEmpenho)
    {
        $this->codEmpenho = $codEmpenho;
        return $this;
    }

    /**
     * Get codEmpenho
     *
     * @return integer
     */
    public function getCodEmpenho()
    {
        return $this->codEmpenho;
    }

    /**
     * Set exercicioEmpenho
     *
     * @param string $exercicioEmpenho
     * @return ConsistenciaContab
     */
    public function setExercicioEmpenho($exercicioEmpenho = null)
    {
        $this->exercicioEmpenho = $exercicioEmpenho;
        return $this;
    }

    /**
     * Get exercicioEmpenho
     *
     * @return string
     */
    public function getExercicioEmpenho()
    {
        return $this->exercicioEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConsistenciaContab
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
     * @return ConsistenciaContab
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
     * Set codLote
     *
     * @param integer $codLote
     * @return ConsistenciaContab
     */
    public function setCodLote($codLote = null)
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
     * Set dtLote
     *
     * @param \DateTime $dtLote
     * @return ConsistenciaContab
     */
    public function setDtLote(\DateTime $dtLote = null)
    {
        $this->dtLote = $dtLote;
        return $this;
    }

    /**
     * Get dtLote
     *
     * @return \DateTime
     */
    public function getDtLote()
    {
        return $this->dtLote;
    }

    /**
     * Set dtEmpenho
     *
     * @param \DateTime $dtEmpenho
     * @return ConsistenciaContab
     */
    public function setDtEmpenho(\DateTime $dtEmpenho = null)
    {
        $this->dtEmpenho = $dtEmpenho;
        return $this;
    }

    /**
     * Get dtEmpenho
     *
     * @return \DateTime
     */
    public function getDtEmpenho()
    {
        return $this->dtEmpenho;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return ConsistenciaContab
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
     * Set estorno
     *
     * @param boolean $estorno
     * @return ConsistenciaContab
     */
    public function setEstorno($estorno = null)
    {
        $this->estorno = $estorno;
        return $this;
    }

    /**
     * Get estorno
     *
     * @return boolean
     */
    public function getEstorno()
    {
        return $this->estorno;
    }

    /**
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ConsistenciaContab
     */
    public function setSequencia($sequencia = null)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set vlLancamento
     *
     * @param integer $vlLancamento
     * @return ConsistenciaContab
     */
    public function setVlLancamento($vlLancamento = null)
    {
        $this->vlLancamento = $vlLancamento;
        return $this;
    }

    /**
     * Get vlLancamento
     *
     * @return integer
     */
    public function getVlLancamento()
    {
        return $this->vlLancamento;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return ConsistenciaContab
     */
    public function setComplemento($complemento = null)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }
}
