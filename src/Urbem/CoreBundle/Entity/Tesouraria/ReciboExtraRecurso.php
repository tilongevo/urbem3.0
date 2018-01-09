<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * ReciboExtraRecurso
 */
class ReciboExtraRecurso
{
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
     * PK
     * @var integer
     */
    private $codReciboExtra;

    /**
     * PK
     * @var string
     */
    private $tipoRecibo;

    /**
     * @var integer
     */
    private $codRecurso;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    private $fkTesourariaReciboExtra;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    private $fkOrcamentoRecurso;

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return ReciboExtraRecurso
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
     * @return ReciboExtraRecurso
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
     * Set codReciboExtra
     *
     * @param integer $codReciboExtra
     * @return ReciboExtraRecurso
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
     * Set tipoRecibo
     *
     * @param string $tipoRecibo
     * @return ReciboExtraRecurso
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
     * Set codRecurso
     *
     * @param integer $codRecurso
     * @return ReciboExtraRecurso
     */
    public function setCodRecurso($codRecurso)
    {
        $this->codRecurso = $codRecurso;
        return $this;
    }

    /**
     * Get codRecurso
     *
     * @return integer
     */
    public function getCodRecurso()
    {
        return $this->codRecurso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoRecurso
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso
     * @return ReciboExtraRecurso
     */
    public function setFkOrcamentoRecurso(\Urbem\CoreBundle\Entity\Orcamento\Recurso $fkOrcamentoRecurso)
    {
        $this->exercicio = $fkOrcamentoRecurso->getExercicio();
        $this->codRecurso = $fkOrcamentoRecurso->getCodRecurso();
        $this->fkOrcamentoRecurso = $fkOrcamentoRecurso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoRecurso
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Recurso
     */
    public function getFkOrcamentoRecurso()
    {
        return $this->fkOrcamentoRecurso;
    }

    /**
     * OneToOne (owning side)
     * Set TesourariaReciboExtra
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra $fkTesourariaReciboExtra
     * @return ReciboExtraRecurso
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
     * OneToOne (owning side)
     * Get fkTesourariaReciboExtra
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\ReciboExtra
     */
    public function getFkTesourariaReciboExtra()
    {
        return $this->fkTesourariaReciboExtra;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codRecurso, $this->fkOrcamentoRecurso->getNomRecurso());
    }
}
