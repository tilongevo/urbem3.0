<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * TodosEmpenhos
 */
class TodosEmpenhos
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
    private $vlrpag;

    /**
     * @var integer
     */
    private $ctbpag;


    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return TodosEmpenhos
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
     * @return TodosEmpenhos
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
     * Set dtEmpenho
     *
     * @param \DateTime $dtEmpenho
     * @return TodosEmpenhos
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
     * @return TodosEmpenhos
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
     * @return TodosEmpenhos
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
     * @return TodosEmpenhos
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
     * @return TodosEmpenhos
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
     * @return TodosEmpenhos
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
     * @return TodosEmpenhos
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
     * Set vlrpag
     *
     * @param integer $vlrpag
     * @return TodosEmpenhos
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
     * @return TodosEmpenhos
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
}
