<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia4
 */
class Consistencia4
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var string
     */
    private $dtEmpenho;

    /**
     * @var string
     */
    private $dtLote;

    /**
     * @var string
     */
    private $complemento;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia4
     */
    public function setCodEntidade($codEntidade)
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
     * @return Consistencia4
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
     * Set dtEmpenho
     *
     * @param string $dtEmpenho
     * @return Consistencia4
     */
    public function setDtEmpenho($dtEmpenho = null)
    {
        $this->dtEmpenho = $dtEmpenho;
        return $this;
    }

    /**
     * Get dtEmpenho
     *
     * @return string
     */
    public function getDtEmpenho()
    {
        return $this->dtEmpenho;
    }

    /**
     * Set dtLote
     *
     * @param string $dtLote
     * @return Consistencia4
     */
    public function setDtLote($dtLote = null)
    {
        $this->dtLote = $dtLote;
        return $this;
    }

    /**
     * Get dtLote
     *
     * @return string
     */
    public function getDtLote()
    {
        return $this->dtLote;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return Consistencia4
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
