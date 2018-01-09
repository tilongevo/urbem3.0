<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * ConcessaoValeTransporte
 */
class ConcessaoValeTransporte
{
    /**
     * PK
     * @var integer
     */
    private $codConcessao;

    /**
     * PK
     * @var integer
     */
    private $codMes;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codValeTransporte;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var boolean
     */
    private $inicializado = false;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario
     */
    private $fkBeneficioConcessaoValeTransporteCalendario;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal
     */
    private $fkBeneficioConcessaoValeTransporteSemanais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte
     */
    private $fkBeneficioContratoServidorConcessaoValeTransportes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte
     */
    private $fkBeneficioGrupoConcessaoValeTransportes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    private $fkAdministracaoMes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte
     */
    private $fkBeneficioValeTransporte;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\TipoConcessaoValeTransporte
     */
    private $fkBeneficioTipoConcessaoValeTransporte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioConcessaoValeTransporteSemanais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioContratoServidorConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkBeneficioGrupoConcessaoValeTransportes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConcessao
     *
     * @param integer $codConcessao
     * @return ConcessaoValeTransporte
     */
    public function setCodConcessao($codConcessao)
    {
        $this->codConcessao = $codConcessao;
        return $this;
    }

    /**
     * Get codConcessao
     *
     * @return integer
     */
    public function getCodConcessao()
    {
        return $this->codConcessao;
    }

    /**
     * Set codMes
     *
     * @param integer $codMes
     * @return ConcessaoValeTransporte
     */
    public function setCodMes($codMes)
    {
        $this->codMes = $codMes;
        return $this;
    }

    /**
     * Get codMes
     *
     * @return integer
     */
    public function getCodMes()
    {
        return $this->codMes;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConcessaoValeTransporte
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
     * Set codValeTransporte
     *
     * @param integer $codValeTransporte
     * @return ConcessaoValeTransporte
     */
    public function setCodValeTransporte($codValeTransporte)
    {
        $this->codValeTransporte = $codValeTransporte;
        return $this;
    }

    /**
     * Get codValeTransporte
     *
     * @return integer
     */
    public function getCodValeTransporte()
    {
        return $this->codValeTransporte;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ConcessaoValeTransporte
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     * @return ConcessaoValeTransporte
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set inicializado
     *
     * @param boolean $inicializado
     * @return ConcessaoValeTransporte
     */
    public function setInicializado($inicializado)
    {
        $this->inicializado = $inicializado;
        return $this;
    }

    /**
     * Get inicializado
     *
     * @return boolean
     */
    public function getInicializado()
    {
        return $this->inicializado;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioConcessaoValeTransporteSemanal
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal
     * @return ConcessaoValeTransporte
     */
    public function addFkBeneficioConcessaoValeTransporteSemanais(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal)
    {
        if (false === $this->fkBeneficioConcessaoValeTransporteSemanais->contains($fkBeneficioConcessaoValeTransporteSemanal)) {
            $fkBeneficioConcessaoValeTransporteSemanal->setFkBeneficioConcessaoValeTransporte($this);
            $this->fkBeneficioConcessaoValeTransporteSemanais->add($fkBeneficioConcessaoValeTransporteSemanal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioConcessaoValeTransporteSemanal
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal
     */
    public function removeFkBeneficioConcessaoValeTransporteSemanais(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal $fkBeneficioConcessaoValeTransporteSemanal)
    {
        $this->fkBeneficioConcessaoValeTransporteSemanais->removeElement($fkBeneficioConcessaoValeTransporteSemanal);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioConcessaoValeTransporteSemanais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteSemanal
     */
    public function getFkBeneficioConcessaoValeTransporteSemanais()
    {
        return $this->fkBeneficioConcessaoValeTransporteSemanais;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioContratoServidorConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte $fkBeneficioContratoServidorConcessaoValeTransporte
     * @return ConcessaoValeTransporte
     */
    public function addFkBeneficioContratoServidorConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte $fkBeneficioContratoServidorConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioContratoServidorConcessaoValeTransportes->contains($fkBeneficioContratoServidorConcessaoValeTransporte)) {
            $fkBeneficioContratoServidorConcessaoValeTransporte->setFkBeneficioConcessaoValeTransporte($this);
            $this->fkBeneficioContratoServidorConcessaoValeTransportes->add($fkBeneficioContratoServidorConcessaoValeTransporte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioContratoServidorConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte $fkBeneficioContratoServidorConcessaoValeTransporte
     */
    public function removeFkBeneficioContratoServidorConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte $fkBeneficioContratoServidorConcessaoValeTransporte)
    {
        $this->fkBeneficioContratoServidorConcessaoValeTransportes->removeElement($fkBeneficioContratoServidorConcessaoValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioContratoServidorConcessaoValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ContratoServidorConcessaoValeTransporte
     */
    public function getFkBeneficioContratoServidorConcessaoValeTransportes()
    {
        return $this->fkBeneficioContratoServidorConcessaoValeTransportes;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioGrupoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte $fkBeneficioGrupoConcessaoValeTransporte
     * @return ConcessaoValeTransporte
     */
    public function addFkBeneficioGrupoConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte $fkBeneficioGrupoConcessaoValeTransporte)
    {
        if (false === $this->fkBeneficioGrupoConcessaoValeTransportes->contains($fkBeneficioGrupoConcessaoValeTransporte)) {
            $fkBeneficioGrupoConcessaoValeTransporte->setFkBeneficioConcessaoValeTransporte($this);
            $this->fkBeneficioGrupoConcessaoValeTransportes->add($fkBeneficioGrupoConcessaoValeTransporte);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioGrupoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte $fkBeneficioGrupoConcessaoValeTransporte
     */
    public function removeFkBeneficioGrupoConcessaoValeTransportes(\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte $fkBeneficioGrupoConcessaoValeTransporte)
    {
        $this->fkBeneficioGrupoConcessaoValeTransportes->removeElement($fkBeneficioGrupoConcessaoValeTransporte);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioGrupoConcessaoValeTransportes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessaoValeTransporte
     */
    public function getFkBeneficioGrupoConcessaoValeTransportes()
    {
        return $this->fkBeneficioGrupoConcessaoValeTransportes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoMes
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes
     * @return ConcessaoValeTransporte
     */
    public function setFkAdministracaoMes(\Urbem\CoreBundle\Entity\Administracao\Mes $fkAdministracaoMes)
    {
        $this->codMes = $fkAdministracaoMes->getCodMes();
        $this->fkAdministracaoMes = $fkAdministracaoMes;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoMes
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Mes
     */
    public function getFkAdministracaoMes()
    {
        return $this->fkAdministracaoMes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte
     * @return ConcessaoValeTransporte
     */
    public function setFkBeneficioValeTransporte(\Urbem\CoreBundle\Entity\Beneficio\ValeTransporte $fkBeneficioValeTransporte)
    {
        $this->codValeTransporte = $fkBeneficioValeTransporte->getCodValeTransporte();
        $this->fkBeneficioValeTransporte = $fkBeneficioValeTransporte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ValeTransporte
     */
    public function getFkBeneficioValeTransporte()
    {
        return $this->fkBeneficioValeTransporte;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioTipoConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\TipoConcessaoValeTransporte $fkBeneficioTipoConcessaoValeTransporte
     * @return ConcessaoValeTransporte
     */
    public function setFkBeneficioTipoConcessaoValeTransporte(\Urbem\CoreBundle\Entity\Beneficio\TipoConcessaoValeTransporte $fkBeneficioTipoConcessaoValeTransporte)
    {
        $this->codTipo = $fkBeneficioTipoConcessaoValeTransporte->getCodTipo();
        $this->fkBeneficioTipoConcessaoValeTransporte = $fkBeneficioTipoConcessaoValeTransporte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioTipoConcessaoValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\TipoConcessaoValeTransporte
     */
    public function getFkBeneficioTipoConcessaoValeTransporte()
    {
        return $this->fkBeneficioTipoConcessaoValeTransporte;
    }

    /**
     * OneToOne (inverse side)
     * Set BeneficioConcessaoValeTransporteCalendario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario $fkBeneficioConcessaoValeTransporteCalendario
     * @return ConcessaoValeTransporte
     */
    public function setFkBeneficioConcessaoValeTransporteCalendario(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario $fkBeneficioConcessaoValeTransporteCalendario)
    {
        $fkBeneficioConcessaoValeTransporteCalendario->setFkBeneficioConcessaoValeTransporte($this);
        $this->fkBeneficioConcessaoValeTransporteCalendario = $fkBeneficioConcessaoValeTransporteCalendario;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkBeneficioConcessaoValeTransporteCalendario
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteCalendario
     */
    public function getFkBeneficioConcessaoValeTransporteCalendario()
    {
        return $this->fkBeneficioConcessaoValeTransporteCalendario;
    }
}
