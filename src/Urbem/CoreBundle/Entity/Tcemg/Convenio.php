<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

/**
 * Convenio
 */
class Convenio
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

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
     * @var integer
     */
    private $nroConvenio;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var \DateTime
     */
    private $dataAssinatura;

    /**
     * @var \DateTime
     */
    private $dataInicio;

    /**
     * @var \DateTime
     */
    private $dataFinal;

    /**
     * @var integer
     */
    private $vlConvenio;

    /**
     * @var integer
     */
    private $vlContraPartida;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioAditivo
     */
    private $fkTcemgConvenioAditivos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho
     */
    private $fkTcemgConvenioEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante
     */
    private $fkTcemgConvenioParticipantes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    private $fkComprasObjeto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcemgConvenioAditivos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConvenioEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgConvenioParticipantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return Convenio
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Convenio
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
     * @return Convenio
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
     * Set nroConvenio
     *
     * @param integer $nroConvenio
     * @return Convenio
     */
    public function setNroConvenio($nroConvenio)
    {
        $this->nroConvenio = $nroConvenio;
        return $this;
    }

    /**
     * Get nroConvenio
     *
     * @return integer
     */
    public function getNroConvenio()
    {
        return $this->nroConvenio;
    }

    /**
     * Set codObjeto
     *
     * @param integer $codObjeto
     * @return Convenio
     */
    public function setCodObjeto($codObjeto)
    {
        $this->codObjeto = $codObjeto;
        return $this;
    }

    /**
     * Get codObjeto
     *
     * @return integer
     */
    public function getCodObjeto()
    {
        return $this->codObjeto;
    }

    /**
     * Set dataAssinatura
     *
     * @param \DateTime $dataAssinatura
     * @return Convenio
     */
    public function setDataAssinatura(\DateTime $dataAssinatura = null)
    {
        $this->dataAssinatura = $dataAssinatura;
        return $this;
    }

    /**
     * Get dataAssinatura
     *
     * @return \DateTime
     */
    public function getDataAssinatura()
    {
        return $this->dataAssinatura;
    }

    /**
     * Set dataInicio
     *
     * @param \DateTime $dataInicio
     * @return Convenio
     */
    public function setDataInicio(\DateTime $dataInicio = null)
    {
        $this->dataInicio = $dataInicio;
        return $this;
    }

    /**
     * Get dataInicio
     *
     * @return \DateTime
     */
    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    /**
     * Set dataFinal
     *
     * @param \DateTime $dataFinal
     * @return Convenio
     */
    public function setDataFinal(\DateTime $dataFinal = null)
    {
        $this->dataFinal = $dataFinal;
        return $this;
    }

    /**
     * Get dataFinal
     *
     * @return \DateTime
     */
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

    /**
     * Set vlConvenio
     *
     * @param integer $vlConvenio
     * @return Convenio
     */
    public function setVlConvenio($vlConvenio)
    {
        $this->vlConvenio = $vlConvenio;
        return $this;
    }

    /**
     * Get vlConvenio
     *
     * @return integer
     */
    public function getVlConvenio()
    {
        return $this->vlConvenio;
    }

    /**
     * Set vlContraPartida
     *
     * @param integer $vlContraPartida
     * @return Convenio
     */
    public function setVlContraPartida($vlContraPartida)
    {
        $this->vlContraPartida = $vlContraPartida;
        return $this;
    }

    /**
     * Get vlContraPartida
     *
     * @return integer
     */
    public function getVlContraPartida()
    {
        return $this->vlContraPartida;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConvenioAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioAditivo $fkTcemgConvenioAditivo
     * @return Convenio
     */
    public function addFkTcemgConvenioAditivos(\Urbem\CoreBundle\Entity\Tcemg\ConvenioAditivo $fkTcemgConvenioAditivo)
    {
        if (false === $this->fkTcemgConvenioAditivos->contains($fkTcemgConvenioAditivo)) {
            $fkTcemgConvenioAditivo->setFkTcemgConvenio($this);
            $this->fkTcemgConvenioAditivos->add($fkTcemgConvenioAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConvenioAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioAditivo $fkTcemgConvenioAditivo
     */
    public function removeFkTcemgConvenioAditivos(\Urbem\CoreBundle\Entity\Tcemg\ConvenioAditivo $fkTcemgConvenioAditivo)
    {
        $this->fkTcemgConvenioAditivos->removeElement($fkTcemgConvenioAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConvenioAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioAditivo
     */
    public function getFkTcemgConvenioAditivos()
    {
        return $this->fkTcemgConvenioAditivos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConvenioEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho $fkTcemgConvenioEmpenho
     * @return Convenio
     */
    public function addFkTcemgConvenioEmpenhos(\Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho $fkTcemgConvenioEmpenho)
    {
        if (false === $this->fkTcemgConvenioEmpenhos->contains($fkTcemgConvenioEmpenho)) {
            $fkTcemgConvenioEmpenho->setFkTcemgConvenio($this);
            $this->fkTcemgConvenioEmpenhos->add($fkTcemgConvenioEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConvenioEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho $fkTcemgConvenioEmpenho
     */
    public function removeFkTcemgConvenioEmpenhos(\Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho $fkTcemgConvenioEmpenho)
    {
        $this->fkTcemgConvenioEmpenhos->removeElement($fkTcemgConvenioEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConvenioEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho
     */
    public function getFkTcemgConvenioEmpenhos()
    {
        return $this->fkTcemgConvenioEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgConvenioParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante
     * @return Convenio
     */
    public function addFkTcemgConvenioParticipantes(\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante)
    {
        if (false === $this->fkTcemgConvenioParticipantes->contains($fkTcemgConvenioParticipante)) {
            $fkTcemgConvenioParticipante->setFkTcemgConvenio($this);
            $this->fkTcemgConvenioParticipantes->add($fkTcemgConvenioParticipante);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgConvenioParticipante
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante
     */
    public function removeFkTcemgConvenioParticipantes(\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante $fkTcemgConvenioParticipante)
    {
        $this->fkTcemgConvenioParticipantes->removeElement($fkTcemgConvenioParticipante);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgConvenioParticipantes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante
     */
    public function getFkTcemgConvenioParticipantes()
    {
        return $this->fkTcemgConvenioParticipantes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasObjeto
     *
     * @param \Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto
     * @return Convenio
     */
    public function setFkComprasObjeto(\Urbem\CoreBundle\Entity\Compras\Objeto $fkComprasObjeto)
    {
        $this->codObjeto = $fkComprasObjeto->getCodObjeto();
        $this->fkComprasObjeto = $fkComprasObjeto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasObjeto
     *
     * @return \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    public function getFkComprasObjeto()
    {
        return $this->fkComprasObjeto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return Convenio
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade = null)
    {
        if (null === $fkOrcamentoEntidade) {
            return $this;
        }

        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }
}
