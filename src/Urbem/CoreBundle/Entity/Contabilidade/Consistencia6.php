<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia6
 */
class Consistencia6
{
    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var string
     */
    private $empenho;

    /**
     * @var integer
     */
    private $vlEmpenho;

    /**
     * @var integer
     */
    private $vlContabilidade;

    /**
     * @var string
     */
    private $descricao;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia6
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
     * Set empenho
     *
     * @param string $empenho
     * @return Consistencia6
     */
    public function setEmpenho($empenho = null)
    {
        $this->empenho = $empenho;
        return $this;
    }

    /**
     * Get empenho
     *
     * @return string
     */
    public function getEmpenho()
    {
        return $this->empenho;
    }

    /**
     * Set vlEmpenho
     *
     * @param integer $vlEmpenho
     * @return Consistencia6
     */
    public function setVlEmpenho($vlEmpenho = null)
    {
        $this->vlEmpenho = $vlEmpenho;
        return $this;
    }

    /**
     * Get vlEmpenho
     *
     * @return integer
     */
    public function getVlEmpenho()
    {
        return $this->vlEmpenho;
    }

    /**
     * Set vlContabilidade
     *
     * @param integer $vlContabilidade
     * @return Consistencia6
     */
    public function setVlContabilidade($vlContabilidade = null)
    {
        $this->vlContabilidade = $vlContabilidade;
        return $this;
    }

    /**
     * Get vlContabilidade
     *
     * @return integer
     */
    public function getVlContabilidade()
    {
        return $this->vlContabilidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Consistencia6
     */
    public function setDescricao($descricao = null)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }
}
