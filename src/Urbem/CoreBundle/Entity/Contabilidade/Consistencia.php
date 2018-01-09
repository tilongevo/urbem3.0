<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * Consistencia
 */
class Consistencia
{
    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codEntidade;

    /**
     * @var \DateTime
     */
    private $dtEmpenho;

    /**
     * @var integer
     */
    private $vlremp;

    /**
     * @var integer
     */
    private $ctbemp;

    /**
     * @var integer
     */
    private $vlranu;

    /**
     * @var integer
     */
    private $ctbanu;

    /**
     * @var integer
     */
    private $vlrliq;

    /**
     * @var integer
     */
    private $ctbliq;

    /**
     * @var integer
     */
    private $vlrliqanu;

    /**
     * @var integer
     */
    private $ctbliqanu;

    /**
     * @var integer
     */
    private $vlrpag;

    /**
     * @var integer
     */
    private $ctbpag;

    /**
     * @var integer
     */
    private $vlrpagest;

    /**
     * @var integer
     */
    private $ctbpagest;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return Consistencia
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return Consistencia
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
     * @return Consistencia
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
     * Set dtEmpenho
     *
     * @param \DateTime $dtEmpenho
     * @return Consistencia
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
     * Set vlremp
     *
     * @param integer $vlremp
     * @return Consistencia
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
     * Set ctbemp
     *
     * @param integer $ctbemp
     * @return Consistencia
     */
    public function setCtbemp($ctbemp = null)
    {
        $this->ctbemp = $ctbemp;
        return $this;
    }

    /**
     * Get ctbemp
     *
     * @return integer
     */
    public function getCtbemp()
    {
        return $this->ctbemp;
    }

    /**
     * Set vlranu
     *
     * @param integer $vlranu
     * @return Consistencia
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
     * Set ctbanu
     *
     * @param integer $ctbanu
     * @return Consistencia
     */
    public function setCtbanu($ctbanu = null)
    {
        $this->ctbanu = $ctbanu;
        return $this;
    }

    /**
     * Get ctbanu
     *
     * @return integer
     */
    public function getCtbanu()
    {
        return $this->ctbanu;
    }

    /**
     * Set vlrliq
     *
     * @param integer $vlrliq
     * @return Consistencia
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
     * Set ctbliq
     *
     * @param integer $ctbliq
     * @return Consistencia
     */
    public function setCtbliq($ctbliq = null)
    {
        $this->ctbliq = $ctbliq;
        return $this;
    }

    /**
     * Get ctbliq
     *
     * @return integer
     */
    public function getCtbliq()
    {
        return $this->ctbliq;
    }

    /**
     * Set vlrliqanu
     *
     * @param integer $vlrliqanu
     * @return Consistencia
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
     * Set ctbliqanu
     *
     * @param integer $ctbliqanu
     * @return Consistencia
     */
    public function setCtbliqanu($ctbliqanu = null)
    {
        $this->ctbliqanu = $ctbliqanu;
        return $this;
    }

    /**
     * Get ctbliqanu
     *
     * @return integer
     */
    public function getCtbliqanu()
    {
        return $this->ctbliqanu;
    }

    /**
     * Set vlrpag
     *
     * @param integer $vlrpag
     * @return Consistencia
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
     * Set ctbpag
     *
     * @param integer $ctbpag
     * @return Consistencia
     */
    public function setCtbpag($ctbpag = null)
    {
        $this->ctbpag = $ctbpag;
        return $this;
    }

    /**
     * Get ctbpag
     *
     * @return integer
     */
    public function getCtbpag()
    {
        return $this->ctbpag;
    }

    /**
     * Set vlrpagest
     *
     * @param integer $vlrpagest
     * @return Consistencia
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

    /**
     * Set ctbpagest
     *
     * @param integer $ctbpagest
     * @return Consistencia
     */
    public function setCtbpagest($ctbpagest = null)
    {
        $this->ctbpagest = $ctbpagest;
        return $this;
    }

    /**
     * Get ctbpagest
     *
     * @return integer
     */
    public function getCtbpagest()
    {
        return $this->ctbpagest;
    }
}
