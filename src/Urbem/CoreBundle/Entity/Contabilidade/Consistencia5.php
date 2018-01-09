<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia5
 */
class Consistencia5
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
    private $vlremp;

    /**
     * @var integer
     */
    private $vlranu;

    /**
     * @var integer
     */
    private $vlrliq;

    /**
     * @var integer
     */
    private $vlrliqanu;

    /**
     * @var integer
     */
    private $vlrpag;

    /**
     * @var integer
     */
    private $vlrpagest;


    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Consistencia5
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
     * @return Consistencia5
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
     * Set vlremp
     *
     * @param integer $vlremp
     * @return Consistencia5
     */
    public function setVlremp($vlremp = null)
    {
        $this->vlremp = $vlremp;
        return $this;
    }

    /**
     * Get vlremp
     *
     * @return integer
     */
    public function getVlremp()
    {
        return $this->vlremp;
    }

    /**
     * Set vlranu
     *
     * @param integer $vlranu
     * @return Consistencia5
     */
    public function setVlranu($vlranu = null)
    {
        $this->vlranu = $vlranu;
        return $this;
    }

    /**
     * Get vlranu
     *
     * @return integer
     */
    public function getVlranu()
    {
        return $this->vlranu;
    }

    /**
     * Set vlrliq
     *
     * @param integer $vlrliq
     * @return Consistencia5
     */
    public function setVlrliq($vlrliq = null)
    {
        $this->vlrliq = $vlrliq;
        return $this;
    }

    /**
     * Get vlrliq
     *
     * @return integer
     */
    public function getVlrliq()
    {
        return $this->vlrliq;
    }

    /**
     * Set vlrliqanu
     *
     * @param integer $vlrliqanu
     * @return Consistencia5
     */
    public function setVlrliqanu($vlrliqanu = null)
    {
        $this->vlrliqanu = $vlrliqanu;
        return $this;
    }

    /**
     * Get vlrliqanu
     *
     * @return integer
     */
    public function getVlrliqanu()
    {
        return $this->vlrliqanu;
    }

    /**
     * Set vlrpag
     *
     * @param integer $vlrpag
     * @return Consistencia5
     */
    public function setVlrpag($vlrpag = null)
    {
        $this->vlrpag = $vlrpag;
        return $this;
    }

    /**
     * Get vlrpag
     *
     * @return integer
     */
    public function getVlrpag()
    {
        return $this->vlrpag;
    }

    /**
     * Set vlrpagest
     *
     * @param integer $vlrpagest
     * @return Consistencia5
     */
    public function setVlrpagest($vlrpagest = null)
    {
        $this->vlrpagest = $vlrpagest;
        return $this;
    }

    /**
     * Get vlrpagest
     *
     * @return integer
     */
    public function getVlrpagest()
    {
        return $this->vlrpagest;
    }
}
