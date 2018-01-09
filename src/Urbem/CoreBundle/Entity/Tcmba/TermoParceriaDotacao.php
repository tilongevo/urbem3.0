<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * TermoParceriaDotacao
 */
class TermoParceriaDotacao
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
    private $nroProcesso;

    /**
     * PK
     * @var string
     */
    private $exercicioDespesa;

    /**
     * PK
     * @var integer
     */
    private $codDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TermoParceria
     */
    private $fkTcmbaTermoParceria;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    private $fkOrcamentoDespesa;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TermoParceriaDotacao
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
     * @return TermoParceriaDotacao
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
     * Set nroProcesso
     *
     * @param string $nroProcesso
     * @return TermoParceriaDotacao
     */
    public function setNroProcesso($nroProcesso)
    {
        $this->nroProcesso = $nroProcesso;
        return $this;
    }

    /**
     * Get nroProcesso
     *
     * @return string
     */
    public function getNroProcesso()
    {
        return $this->nroProcesso;
    }

    /**
     * Set exercicioDespesa
     *
     * @param string $exercicioDespesa
     * @return TermoParceriaDotacao
     */
    public function setExercicioDespesa($exercicioDespesa)
    {
        $this->exercicioDespesa = $exercicioDespesa;
        return $this;
    }

    /**
     * Get exercicioDespesa
     *
     * @return string
     */
    public function getExercicioDespesa()
    {
        return $this->exercicioDespesa;
    }

    /**
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return TermoParceriaDotacao
     */
    public function setCodDespesa($codDespesa)
    {
        $this->codDespesa = $codDespesa;
        return $this;
    }

    /**
     * Get codDespesa
     *
     * @return integer
     */
    public function getCodDespesa()
    {
        return $this->codDespesa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcmbaTermoParceria
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria
     * @return TermoParceriaDotacao
     */
    public function setFkTcmbaTermoParceria(\Urbem\CoreBundle\Entity\Tcmba\TermoParceria $fkTcmbaTermoParceria)
    {
        $this->exercicio = $fkTcmbaTermoParceria->getExercicio();
        $this->codEntidade = $fkTcmbaTermoParceria->getCodEntidade();
        $this->nroProcesso = $fkTcmbaTermoParceria->getNroProcesso();
        $this->fkTcmbaTermoParceria = $fkTcmbaTermoParceria;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTermoParceria
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TermoParceria
     */
    public function getFkTcmbaTermoParceria()
    {
        return $this->fkTcmbaTermoParceria;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa
     * @return TermoParceriaDotacao
     */
    public function setFkOrcamentoDespesa(\Urbem\CoreBundle\Entity\Orcamento\Despesa $fkOrcamentoDespesa)
    {
        $this->exercicioDespesa = $fkOrcamentoDespesa->getExercicio();
        $this->codDespesa = $fkOrcamentoDespesa->getCodDespesa();
        $this->fkOrcamentoDespesa = $fkOrcamentoDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Despesa
     */
    public function getFkOrcamentoDespesa()
    {
        return $this->fkOrcamentoDespesa;
    }
}
