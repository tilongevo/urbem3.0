<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia9
 */
class Consistencia9
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
    private $tipo;

    /**
     * @var string
     */
    private $complemento;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia9
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
     * @return Consistencia9
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
     * Set tipo
     *
     * @param string $tipo
     * @return Consistencia9
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
     * Set complemento
     *
     * @param string $complemento
     * @return Consistencia9
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
