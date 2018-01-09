<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ReciboExtraAssinatura
 */
class ReciboExtraAssinatura
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var string
     */
    private $tipoRecibo;

    /**
     * PK
     * @var integer
     */
    private $codReciboExtra;

    /**
     * PK
     * @var integer
     */
    private $numAssinatura;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var string
     */
    private $cargo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    private $fkTesourariaReciboExtra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReciboExtraAssinatura
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ReciboExtraAssinatura
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
     * Set tipoRecibo
     *
     * @param string $tipoRecibo
     * @return ReciboExtraAssinatura
     */
    public function setTipoRecibo($tipoRecibo)
    {
        $this->tipoRecibo = $tipoRecibo;
        return $this;
    }

    /**
     * Get tipoRecibo
     *
     * @return string
     */
    public function getTipoRecibo()
    {
        return $this->tipoRecibo;
    }

    /**
     * Set codReciboExtra
     *
     * @param integer $codReciboExtra
     * @return ReciboExtraAssinatura
     */
    public function setCodReciboExtra($codReciboExtra)
    {
        $this->codReciboExtra = $codReciboExtra;
        return $this;
    }

    /**
     * Get codReciboExtra
     *
     * @return integer
     */
    public function getCodReciboExtra()
    {
        return $this->codReciboExtra;
    }

    /**
     * Set numAssinatura
     *
     * @param integer $numAssinatura
     * @return ReciboExtraAssinatura
     */
    public function setNumAssinatura($numAssinatura)
    {
        $this->numAssinatura = $numAssinatura;
        return $this;
    }

    /**
     * Get numAssinatura
     *
     * @return integer
     */
    public function getNumAssinatura()
    {
        return $this->numAssinatura;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return ReciboExtraAssinatura
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return ReciboExtraAssinatura
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
        return $this;
    }

    /**
     * Get cargo
     *
     * @return string
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     * @return ReciboExtraAssinatura
     */
    public function setFkTesourariaReciboExtra(\Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra)
    {
        $this->codReciboExtra = $fkTesourariaReciboExtra->getCodReciboExtra();
        $this->exercicio = $fkTesourariaReciboExtra->getExercicio();
        $this->codEntidade = $fkTesourariaReciboExtra->getCodEntidade();
        $this->tipoRecibo = $fkTesourariaReciboExtra->getTipoRecibo();
        $this->fkTesourariaReciboExtra = $fkTesourariaReciboExtra;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaReciboExtra
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    public function getFkTesourariaReciboExtra()
    {
        return $this->fkTesourariaReciboExtra;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return ReciboExtraAssinatura
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }
}
