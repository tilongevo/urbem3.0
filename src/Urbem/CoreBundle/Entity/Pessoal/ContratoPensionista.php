<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * ContratoPensionista
 */
class ContratoPensionista
{
    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * @var integer
     */
    private $codContratoCedente;

    /**
     * @var integer
     */
    private $codDependencia;

    /**
     * @var integer
     */
    private $codPensionista;

    /**
     * @var string
     */
    private $numBeneficio;

    /**
     * @var integer
     */
    private $percentualPagamento;

    /**
     * @var \DateTime
     */
    private $dtInicioBeneficio;

    /**
     * @var \DateTime
     */
    private $dtEncerramento;

    /**
     * @var string
     */
    private $motivoEncerramento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso
     */
    private $fkPessoalContratoPensionistaProcesso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa
     */
    private $fkPessoalContratoPensionistaCasoCausa;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista
     */
    private $fkPessoalAtributoContratoPensionistas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario
     */
    private $fkPessoalContratoPensionistaContaSalarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao
     */
    private $fkPessoalContratoPensionistaOrgoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia
     */
    private $fkPessoalContratoPensionistaPrevidencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Pensionista
     */
    private $fkPessoalPensionista;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\TipoDependencia
     */
    private $fkPessoalTipoDependencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalAtributoContratoPensionistas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaContaSalarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaOrgoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaPrevidencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoPensionista
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codContratoCedente
     *
     * @param integer $codContratoCedente
     * @return ContratoPensionista
     */
    public function setCodContratoCedente($codContratoCedente)
    {
        $this->codContratoCedente = $codContratoCedente;
        return $this;
    }

    /**
     * Get codContratoCedente
     *
     * @return integer
     */
    public function getCodContratoCedente()
    {
        return $this->codContratoCedente;
    }

    /**
     * Set codDependencia
     *
     * @param integer $codDependencia
     * @return ContratoPensionista
     */
    public function setCodDependencia($codDependencia)
    {
        $this->codDependencia = $codDependencia;
        return $this;
    }

    /**
     * Get codDependencia
     *
     * @return integer
     */
    public function getCodDependencia()
    {
        return $this->codDependencia;
    }

    /**
     * Set codPensionista
     *
     * @param integer $codPensionista
     * @return ContratoPensionista
     */
    public function setCodPensionista($codPensionista)
    {
        $this->codPensionista = $codPensionista;
        return $this;
    }

    /**
     * Get codPensionista
     *
     * @return integer
     */
    public function getCodPensionista()
    {
        return $this->codPensionista;
    }

    /**
     * Set numBeneficio
     *
     * @param string $numBeneficio
     * @return ContratoPensionista
     */
    public function setNumBeneficio($numBeneficio = null)
    {
        $this->numBeneficio = $numBeneficio;
        return $this;
    }

    /**
     * Get numBeneficio
     *
     * @return string
     */
    public function getNumBeneficio()
    {
        return $this->numBeneficio;
    }

    /**
     * Set percentualPagamento
     *
     * @param integer $percentualPagamento
     * @return ContratoPensionista
     */
    public function setPercentualPagamento($percentualPagamento = null)
    {
        $this->percentualPagamento = $percentualPagamento;
        return $this;
    }

    /**
     * Get percentualPagamento
     *
     * @return integer
     */
    public function getPercentualPagamento()
    {
        return $this->percentualPagamento;
    }

    /**
     * Set dtInicioBeneficio
     *
     * @param \DateTime $dtInicioBeneficio
     * @return ContratoPensionista
     */
    public function setDtInicioBeneficio(\DateTime $dtInicioBeneficio)
    {
        $this->dtInicioBeneficio = $dtInicioBeneficio;
        return $this;
    }

    /**
     * Get dtInicioBeneficio
     *
     * @return \DateTime
     */
    public function getDtInicioBeneficio()
    {
        return $this->dtInicioBeneficio;
    }

    /**
     * Set dtEncerramento
     *
     * @param \DateTime $dtEncerramento
     * @return ContratoPensionista
     */
    public function setDtEncerramento(\DateTime $dtEncerramento = null)
    {
        $this->dtEncerramento = $dtEncerramento;
        return $this;
    }

    /**
     * Get dtEncerramento
     *
     * @return \DateTime
     */
    public function getDtEncerramento()
    {
        return $this->dtEncerramento;
    }

    /**
     * Set motivoEncerramento
     *
     * @param string $motivoEncerramento
     * @return ContratoPensionista
     */
    public function setMotivoEncerramento($motivoEncerramento = null)
    {
        $this->motivoEncerramento = $motivoEncerramento;
        return $this;
    }

    /**
     * Get motivoEncerramento
     *
     * @return string
     */
    public function getMotivoEncerramento()
    {
        return $this->motivoEncerramento;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalAtributoContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista $fkPessoalAtributoContratoPensionista
     * @return ContratoPensionista
     */
    public function addFkPessoalAtributoContratoPensionistas(\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista $fkPessoalAtributoContratoPensionista)
    {
        if (false === $this->fkPessoalAtributoContratoPensionistas->contains($fkPessoalAtributoContratoPensionista)) {
            $fkPessoalAtributoContratoPensionista->setFkPessoalContratoPensionista($this);
            $this->fkPessoalAtributoContratoPensionistas->add($fkPessoalAtributoContratoPensionista);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalAtributoContratoPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista $fkPessoalAtributoContratoPensionista
     */
    public function removeFkPessoalAtributoContratoPensionistas(\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista $fkPessoalAtributoContratoPensionista)
    {
        $this->fkPessoalAtributoContratoPensionistas->removeElement($fkPessoalAtributoContratoPensionista);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalAtributoContratoPensionistas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista
     */
    public function getFkPessoalAtributoContratoPensionistas()
    {
        return $this->fkPessoalAtributoContratoPensionistas;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaContaSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario $fkPessoalContratoPensionistaContaSalario
     * @return ContratoPensionista
     */
    public function addFkPessoalContratoPensionistaContaSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario $fkPessoalContratoPensionistaContaSalario)
    {
        if (false === $this->fkPessoalContratoPensionistaContaSalarios->contains($fkPessoalContratoPensionistaContaSalario)) {
            $fkPessoalContratoPensionistaContaSalario->setFkPessoalContratoPensionista($this);
            $this->fkPessoalContratoPensionistaContaSalarios->add($fkPessoalContratoPensionistaContaSalario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaContaSalario
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario $fkPessoalContratoPensionistaContaSalario
     */
    public function removeFkPessoalContratoPensionistaContaSalarios(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario $fkPessoalContratoPensionistaContaSalario)
    {
        $this->fkPessoalContratoPensionistaContaSalarios->removeElement($fkPessoalContratoPensionistaContaSalario);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaContaSalarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaContaSalario
     */
    public function getFkPessoalContratoPensionistaContaSalarios()
    {
        return $this->fkPessoalContratoPensionistaContaSalarios;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao $fkPessoalContratoPensionistaOrgao
     * @return ContratoPensionista
     */
    public function addFkPessoalContratoPensionistaOrgoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao $fkPessoalContratoPensionistaOrgao)
    {
        if (false === $this->fkPessoalContratoPensionistaOrgoes->contains($fkPessoalContratoPensionistaOrgao)) {
            $fkPessoalContratoPensionistaOrgao->setFkPessoalContratoPensionista($this);
            $this->fkPessoalContratoPensionistaOrgoes->add($fkPessoalContratoPensionistaOrgao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao $fkPessoalContratoPensionistaOrgao
     */
    public function removeFkPessoalContratoPensionistaOrgoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao $fkPessoalContratoPensionistaOrgao)
    {
        $this->fkPessoalContratoPensionistaOrgoes->removeElement($fkPessoalContratoPensionistaOrgao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaOrgoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao
     */
    public function getFkPessoalContratoPensionistaOrgoes()
    {
        return $this->fkPessoalContratoPensionistaOrgoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia $fkPessoalContratoPensionistaPrevidencia
     * @return ContratoPensionista
     */
    public function addFkPessoalContratoPensionistaPrevidencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia $fkPessoalContratoPensionistaPrevidencia)
    {
        if (false === $this->fkPessoalContratoPensionistaPrevidencias->contains($fkPessoalContratoPensionistaPrevidencia)) {
            $fkPessoalContratoPensionistaPrevidencia->setFkPessoalContratoPensionista($this);
            $this->fkPessoalContratoPensionistaPrevidencias->add($fkPessoalContratoPensionistaPrevidencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia $fkPessoalContratoPensionistaPrevidencia
     */
    public function removeFkPessoalContratoPensionistaPrevidencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia $fkPessoalContratoPensionistaPrevidencia)
    {
        $this->fkPessoalContratoPensionistaPrevidencias->removeElement($fkPessoalContratoPensionistaPrevidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaPrevidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia
     */
    public function getFkPessoalContratoPensionistaPrevidencias()
    {
        return $this->fkPessoalContratoPensionistaPrevidencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalPensionista
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista
     * @return ContratoPensionista
     */
    public function setFkPessoalPensionista(\Urbem\CoreBundle\Entity\Pessoal\Pensionista $fkPessoalPensionista)
    {
        $this->codPensionista = $fkPessoalPensionista->getCodPensionista();
        $this->codContratoCedente = $fkPessoalPensionista->getCodContratoCedente();
        $this->fkPessoalPensionista = $fkPessoalPensionista;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalPensionista
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Pensionista
     */
    public function getFkPessoalPensionista()
    {
        return $this->fkPessoalPensionista;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalTipoDependencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\TipoDependencia $fkPessoalTipoDependencia
     * @return ContratoPensionista
     */
    public function setFkPessoalTipoDependencia(\Urbem\CoreBundle\Entity\Pessoal\TipoDependencia $fkPessoalTipoDependencia)
    {
        $this->codDependencia = $fkPessoalTipoDependencia->getCodDependencia();
        $this->fkPessoalTipoDependencia = $fkPessoalTipoDependencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalTipoDependencia
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\TipoDependencia
     */
    public function getFkPessoalTipoDependencia()
    {
        return $this->fkPessoalTipoDependencia;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoPensionistaProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso $fkPessoalContratoPensionistaProcesso
     * @return ContratoPensionista
     */
    public function setFkPessoalContratoPensionistaProcesso(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso $fkPessoalContratoPensionistaProcesso)
    {
        $fkPessoalContratoPensionistaProcesso->setFkPessoalContratoPensionista($this);
        $this->fkPessoalContratoPensionistaProcesso = $fkPessoalContratoPensionistaProcesso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoPensionistaProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaProcesso
     */
    public function getFkPessoalContratoPensionistaProcesso()
    {
        return $this->fkPessoalContratoPensionistaProcesso;
    }

    /**
     * OneToOne (inverse side)
     * Set PessoalContratoPensionistaCasoCausa
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa
     * @return ContratoPensionista
     */
    public function setFkPessoalContratoPensionistaCasoCausa(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa $fkPessoalContratoPensionistaCasoCausa)
    {
        $fkPessoalContratoPensionistaCasoCausa->setFkPessoalContratoPensionista($this);
        $this->fkPessoalContratoPensionistaCasoCausa = $fkPessoalContratoPensionistaCasoCausa;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPessoalContratoPensionistaCasoCausa
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaCasoCausa
     */
    public function getFkPessoalContratoPensionistaCasoCausa()
    {
        return $this->fkPessoalContratoPensionistaCasoCausa;
    }

    /**
     * OneToOne (owning side)
     * Set PessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return ContratoPensionista
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }
}
