<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * Convenio
 */
class Convenio
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
    private $numConvenio;

    /**
     * @var integer
     */
    private $codProcesso;

    /**
     * @var string
     */
    private $exercicioProcesso;

    /**
     * @var integer
     */
    private $numcgmRecebedor;

    /**
     * @var integer
     */
    private $codObjeto;

    /**
     * @var integer
     */
    private $codRecurso1;

    /**
     * @var integer
     */
    private $codRecurso2;

    /**
     * @var integer
     */
    private $codRecurso3;

    /**
     * @var integer
     */
    private $valorRecurso1;

    /**
     * @var integer
     */
    private $valorRecurso2;

    /**
     * @var integer
     */
    private $valorRecurso3;

    /**
     * @var \DateTime
     */
    private $dtInicioVigencia;

    /**
     * @var \DateTime
     */
    private $dtTerminoVigencia;

    /**
     * @var \DateTime
     */
    private $dtAssinatura;

    /**
     * @var \DateTime
     */
    private $dtPublicacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\Contrato
     */
    private $fkTcernContratos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo
     */
    private $fkTcernContratoAditivos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcesso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\Objeto
     */
    private $fkComprasObjeto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernContratos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcernContratoAditivos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return Convenio
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return Convenio
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set exercicioProcesso
     *
     * @param string $exercicioProcesso
     * @return Convenio
     */
    public function setExercicioProcesso($exercicioProcesso)
    {
        $this->exercicioProcesso = $exercicioProcesso;
        return $this;
    }

    /**
     * Get exercicioProcesso
     *
     * @return string
     */
    public function getExercicioProcesso()
    {
        return $this->exercicioProcesso;
    }

    /**
     * Set numcgmRecebedor
     *
     * @param integer $numcgmRecebedor
     * @return Convenio
     */
    public function setNumcgmRecebedor($numcgmRecebedor)
    {
        $this->numcgmRecebedor = $numcgmRecebedor;
        return $this;
    }

    /**
     * Get numcgmRecebedor
     *
     * @return integer
     */
    public function getNumcgmRecebedor()
    {
        return $this->numcgmRecebedor;
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
     * Set codRecurso1
     *
     * @param integer $codRecurso1
     * @return Convenio
     */
    public function setCodRecurso1($codRecurso1 = null)
    {
        $this->codRecurso1 = $codRecurso1;
        return $this;
    }

    /**
     * Get codRecurso1
     *
     * @return integer
     */
    public function getCodRecurso1()
    {
        return $this->codRecurso1;
    }

    /**
     * Set codRecurso2
     *
     * @param integer $codRecurso2
     * @return Convenio
     */
    public function setCodRecurso2($codRecurso2 = null)
    {
        $this->codRecurso2 = $codRecurso2;
        return $this;
    }

    /**
     * Get codRecurso2
     *
     * @return integer
     */
    public function getCodRecurso2()
    {
        return $this->codRecurso2;
    }

    /**
     * Set codRecurso3
     *
     * @param integer $codRecurso3
     * @return Convenio
     */
    public function setCodRecurso3($codRecurso3 = null)
    {
        $this->codRecurso3 = $codRecurso3;
        return $this;
    }

    /**
     * Get codRecurso3
     *
     * @return integer
     */
    public function getCodRecurso3()
    {
        return $this->codRecurso3;
    }

    /**
     * Set valorRecurso1
     *
     * @param integer $valorRecurso1
     * @return Convenio
     */
    public function setValorRecurso1($valorRecurso1 = null)
    {
        $this->valorRecurso1 = $valorRecurso1;
        return $this;
    }

    /**
     * Get valorRecurso1
     *
     * @return integer
     */
    public function getValorRecurso1()
    {
        return $this->valorRecurso1;
    }

    /**
     * Set valorRecurso2
     *
     * @param integer $valorRecurso2
     * @return Convenio
     */
    public function setValorRecurso2($valorRecurso2 = null)
    {
        $this->valorRecurso2 = $valorRecurso2;
        return $this;
    }

    /**
     * Get valorRecurso2
     *
     * @return integer
     */
    public function getValorRecurso2()
    {
        return $this->valorRecurso2;
    }

    /**
     * Set valorRecurso3
     *
     * @param integer $valorRecurso3
     * @return Convenio
     */
    public function setValorRecurso3($valorRecurso3 = null)
    {
        $this->valorRecurso3 = $valorRecurso3;
        return $this;
    }

    /**
     * Get valorRecurso3
     *
     * @return integer
     */
    public function getValorRecurso3()
    {
        return $this->valorRecurso3;
    }

    /**
     * Set dtInicioVigencia
     *
     * @param \DateTime $dtInicioVigencia
     * @return Convenio
     */
    public function setDtInicioVigencia(\DateTime $dtInicioVigencia)
    {
        $this->dtInicioVigencia = $dtInicioVigencia;
        return $this;
    }

    /**
     * Get dtInicioVigencia
     *
     * @return \DateTime
     */
    public function getDtInicioVigencia()
    {
        return $this->dtInicioVigencia;
    }

    /**
     * Set dtTerminoVigencia
     *
     * @param \DateTime $dtTerminoVigencia
     * @return Convenio
     */
    public function setDtTerminoVigencia(\DateTime $dtTerminoVigencia)
    {
        $this->dtTerminoVigencia = $dtTerminoVigencia;
        return $this;
    }

    /**
     * Get dtTerminoVigencia
     *
     * @return \DateTime
     */
    public function getDtTerminoVigencia()
    {
        return $this->dtTerminoVigencia;
    }

    /**
     * Set dtAssinatura
     *
     * @param \DateTime $dtAssinatura
     * @return Convenio
     */
    public function setDtAssinatura(\DateTime $dtAssinatura)
    {
        $this->dtAssinatura = $dtAssinatura;
        return $this;
    }

    /**
     * Get dtAssinatura
     *
     * @return \DateTime
     */
    public function getDtAssinatura()
    {
        return $this->dtAssinatura;
    }

    /**
     * Set dtPublicacao
     *
     * @param \DateTime $dtPublicacao
     * @return Convenio
     */
    public function setDtPublicacao(\DateTime $dtPublicacao)
    {
        $this->dtPublicacao = $dtPublicacao;
        return $this;
    }

    /**
     * Get dtPublicacao
     *
     * @return \DateTime
     */
    public function getDtPublicacao()
    {
        return $this->dtPublicacao;
    }

    /**
     * OneToMany (owning side)
     * Add TcernContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Contrato $fkTcernContrato
     * @return Convenio
     */
    public function addFkTcernContratos(\Urbem\CoreBundle\Entity\Tcern\Contrato $fkTcernContrato)
    {
        if (false === $this->fkTcernContratos->contains($fkTcernContrato)) {
            $fkTcernContrato->setFkTcernConvenio($this);
            $this->fkTcernContratos->add($fkTcernContrato);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernContrato
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\Contrato $fkTcernContrato
     */
    public function removeFkTcernContratos(\Urbem\CoreBundle\Entity\Tcern\Contrato $fkTcernContrato)
    {
        $this->fkTcernContratos->removeElement($fkTcernContrato);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernContratos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\Contrato
     */
    public function getFkTcernContratos()
    {
        return $this->fkTcernContratos;
    }

    /**
     * OneToMany (owning side)
     * Add TcernContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo
     * @return Convenio
     */
    public function addFkTcernContratoAditivos(\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo)
    {
        if (false === $this->fkTcernContratoAditivos->contains($fkTcernContratoAditivo)) {
            $fkTcernContratoAditivo->setFkTcernConvenio($this);
            $this->fkTcernContratoAditivos->add($fkTcernContratoAditivo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernContratoAditivo
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo
     */
    public function removeFkTcernContratoAditivos(\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo $fkTcernContratoAditivo)
    {
        $this->fkTcernContratoAditivos->removeElement($fkTcernContratoAditivo);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernContratoAditivos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ContratoAditivo
     */
    public function getFkTcernContratoAditivos()
    {
        return $this->fkTcernContratoAditivos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return Convenio
     */
    public function setFkSwProcesso(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->codProcesso = $fkSwProcesso->getCodProcesso();
        $this->exercicioProcesso = $fkSwProcesso->getAnoExercicio();
        $this->fkSwProcesso = $fkSwProcesso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwProcesso
     *
     * @return \Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcesso()
    {
        return $this->fkSwProcesso;
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
}
