<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia8
 */
class Consistencia8
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
     * @var integer
     */
    private $lancamentos;

    /**
     * @var integer
     */
    private $lancamentosCorretos;

    /**
     * @var string
     */
    private $complemento;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia8
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
     * @return Consistencia8
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
     * @return Consistencia8
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
     * Set lancamentos
     *
     * @param integer $lancamentos
     * @return Consistencia8
     */
    public function setLancamentos($lancamentos = null)
    {
        $this->lancamentos = $lancamentos;
        return $this;
    }

    /**
     * Get lancamentos
     *
     * @return integer
     */
    public function getLancamentos()
    {
        return $this->lancamentos;
    }

    /**
     * Set lancamentosCorretos
     *
     * @param integer $lancamentosCorretos
     * @return Consistencia8
     */
    public function setLancamentosCorretos($lancamentosCorretos = null)
    {
        $this->lancamentosCorretos = $lancamentosCorretos;
        return $this;
    }

    /**
     * Get lancamentosCorretos
     *
     * @return integer
     */
    public function getLancamentosCorretos()
    {
        return $this->lancamentosCorretos;
    }

    /**
     * Set complemento
     *
     * @param string $complemento
     * @return Consistencia8
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
