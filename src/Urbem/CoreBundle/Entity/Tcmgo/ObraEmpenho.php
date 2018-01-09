<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ObraEmpenho
 */
class ObraEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $anoObra;

    /**
     * PK
     * @var integer
     */
    private $codObra;

    /**
     * PK
     * @var integer
     */
    private $codEmpenho;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\Obra
     */
    private $fkTcmgoObra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    private $fkEmpenhoEmpenho;


    /**
     * Set anoObra
     *
     * @param integer $anoObra
     * @return ObraEmpenho
     */
    public function setAnoObra($anoObra)
    {
        $this->anoObra = $anoObra;
        return $this;
    }

    /**
     * Get anoObra
     *
     * @return integer
     */
    public function getAnoObra()
    {
        return $this->anoObra;
    }

    /**
     * Set codObra
     *
     * @param integer $codObra
     * @return ObraEmpenho
     */
    public function setCodObra($codObra)
    {
        $this->codObra = $codObra;
        return $this;
    }

    /**
     * Get codObra
     *
     * @return integer
     */
    public function getCodObra()
    {
        return $this->codObra;
    }

    /**
     * Set codEmpenho
     *
     * @param integer $codEmpenho
     * @return ObraEmpenho
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ObraEmpenho
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ObraEmpenho
     */
    public function setExercicio($exercicio)
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
     * ManyToOne (inverse side)
     * Set fkTcmgoObra
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\Obra $fkTcmgoObra
     * @return ObraEmpenho
     */
    public function setFkTcmgoObra(\Urbem\CoreBundle\Entity\Tcmgo\Obra $fkTcmgoObra)
    {
        $this->codObra = $fkTcmgoObra->getCodObra();
        $this->anoObra = $fkTcmgoObra->getAnoObra();
        $this->fkTcmgoObra = $fkTcmgoObra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoObra
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\Obra
     */
    public function getFkTcmgoObra()
    {
        return $this->fkTcmgoObra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEmpenhoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho
     * @return ObraEmpenho
     */
    public function setFkEmpenhoEmpenho(\Urbem\CoreBundle\Entity\Empenho\Empenho $fkEmpenhoEmpenho)
    {
        $this->codEmpenho = $fkEmpenhoEmpenho->getCodEmpenho();
        $this->exercicio = $fkEmpenhoEmpenho->getExercicio();
        $this->codEntidade = $fkEmpenhoEmpenho->getCodEntidade();
        $this->fkEmpenhoEmpenho = $fkEmpenhoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEmpenhoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\Empenho
     */
    public function getFkEmpenhoEmpenho()
    {
        return $this->fkEmpenhoEmpenho;
    }
}
