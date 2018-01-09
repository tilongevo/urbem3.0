<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * ConcessaoValeTransporteSemanal
 */
class ConcessaoValeTransporteSemanal
{
    /**
     * PK
     * @var integer
     */
    private $codDia;

    /**
     * PK
     * @var integer
     */
    private $codMes;

    /**
     * PK
     * @var integer
     */
    private $codConcessao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $quantidade;

    /**
     * @var boolean
     */
    private $obrigatorio = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteDiario
     */
    private $fkBeneficioConcessaoValeTransporteDiarios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\DiasSemana
     */
    private $fkAdministracaoDiasSemana;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    private $fkBeneficioConcessaoValeTransporte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkBeneficioConcessaoValeTransporteDiarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDia
     *
     * @param integer $codDia
     * @return ConcessaoValeTransporteSemanal
     */
    public function setCodDia($codDia)
    {
        $this->codDia = $codDia;
        return $this;
    }

    /**
     * Get codDia
     *
     * @return integer
     */
    public function getCodDia()
    {
        return $this->codDia;
    }

    /**
     * Set codMes
     *
     * @param integer $codMes
     * @return ConcessaoValeTransporteSemanal
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
     * Set codConcessao
     *
     * @param integer $codConcessao
     * @return ConcessaoValeTransporteSemanal
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConcessaoValeTransporteSemanal
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
     * Set quantidade
     *
     * @param integer $quantidade
     * @return ConcessaoValeTransporteSemanal
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
     * Set obrigatorio
     *
     * @param boolean $obrigatorio
     * @return ConcessaoValeTransporteSemanal
     */
    public function setObrigatorio($obrigatorio)
    {
        $this->obrigatorio = $obrigatorio;
        return $this;
    }

    /**
     * Get obrigatorio
     *
     * @return boolean
     */
    public function getObrigatorio()
    {
        return $this->obrigatorio;
    }

    /**
     * OneToMany (owning side)
     * Add BeneficioConcessaoValeTransporteDiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteDiario $fkBeneficioConcessaoValeTransporteDiario
     * @return ConcessaoValeTransporteSemanal
     */
    public function addFkBeneficioConcessaoValeTransporteDiarios(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteDiario $fkBeneficioConcessaoValeTransporteDiario)
    {
        if (false === $this->fkBeneficioConcessaoValeTransporteDiarios->contains($fkBeneficioConcessaoValeTransporteDiario)) {
            $fkBeneficioConcessaoValeTransporteDiario->setFkBeneficioConcessaoValeTransporteSemanal($this);
            $this->fkBeneficioConcessaoValeTransporteDiarios->add($fkBeneficioConcessaoValeTransporteDiario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove BeneficioConcessaoValeTransporteDiario
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteDiario $fkBeneficioConcessaoValeTransporteDiario
     */
    public function removeFkBeneficioConcessaoValeTransporteDiarios(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteDiario $fkBeneficioConcessaoValeTransporteDiario)
    {
        $this->fkBeneficioConcessaoValeTransporteDiarios->removeElement($fkBeneficioConcessaoValeTransporteDiario);
    }

    /**
     * OneToMany (owning side)
     * Get fkBeneficioConcessaoValeTransporteDiarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporteDiario
     */
    public function getFkBeneficioConcessaoValeTransporteDiarios()
    {
        return $this->fkBeneficioConcessaoValeTransporteDiarios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoDiasSemana
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\DiasSemana $fkAdministracaoDiasSemana
     * @return ConcessaoValeTransporteSemanal
     */
    public function setFkAdministracaoDiasSemana(\Urbem\CoreBundle\Entity\Administracao\DiasSemana $fkAdministracaoDiasSemana)
    {
        $this->codDia = $fkAdministracaoDiasSemana->getCodDia();
        $this->fkAdministracaoDiasSemana = $fkAdministracaoDiasSemana;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoDiasSemana
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\DiasSemana
     */
    public function getFkAdministracaoDiasSemana()
    {
        return $this->fkAdministracaoDiasSemana;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioConcessaoValeTransporte
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte
     * @return ConcessaoValeTransporteSemanal
     */
    public function setFkBeneficioConcessaoValeTransporte(\Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte $fkBeneficioConcessaoValeTransporte)
    {
        $this->codConcessao = $fkBeneficioConcessaoValeTransporte->getCodConcessao();
        $this->codMes = $fkBeneficioConcessaoValeTransporte->getCodMes();
        $this->exercicio = $fkBeneficioConcessaoValeTransporte->getExercicio();
        $this->fkBeneficioConcessaoValeTransporte = $fkBeneficioConcessaoValeTransporte;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioConcessaoValeTransporte
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\ConcessaoValeTransporte
     */
    public function getFkBeneficioConcessaoValeTransporte()
    {
        return $this->fkBeneficioConcessaoValeTransporte;
    }
}
