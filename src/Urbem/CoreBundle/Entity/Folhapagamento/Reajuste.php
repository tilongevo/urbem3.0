<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Reajuste
 */
class Reajuste
{
    /**
     * PK
     * @var integer
     */
    private $codReajuste;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtReajuste;

    /**
     * @var integer
     */
    private $faixaInicial;

    /**
     * @var integer
     */
    private $faixaFinal;

    /**
     * @var string
     */
    private $origem;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao
     */
    private $fkFolhapagamentoReajusteExclusao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ReajustePercentual
     */
    private $fkFolhapagamentoReajustePercentual;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteAbsoluto
     */
    private $fkFolhapagamentoReajusteAbsoluto;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario
     */
    private $fkFolhapagamentoReajusteContratoServidorSalarios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao
     */
    private $fkFolhapagamentoReajustePadraoPadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo
     */
    private $fkFolhapagamentoReajusteRegistroEventoDecimos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias
     */
    private $fkFolhapagamentoReajusteRegistroEventoFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao
     */
    private $fkFolhapagamentoReajusteRegistroEventoRescisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar
     */
    private $fkFolhapagamentoReajusteRegistroEventoComplementares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento
     */
    private $fkFolhapagamentoReajusteRegistroEventos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoReajusteContratoServidorSalarios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajustePadraoPadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajusteRegistroEventoDecimos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajusteRegistroEventoFerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajusteRegistroEventoRescisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajusteRegistroEventoComplementares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoReajusteRegistroEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codReajuste
     *
     * @param integer $codReajuste
     * @return Reajuste
     */
    public function setCodReajuste($codReajuste)
    {
        $this->codReajuste = $codReajuste;
        return $this;
    }

    /**
     * Get codReajuste
     *
     * @return integer
     */
    public function getCodReajuste()
    {
        return $this->codReajuste;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Reajuste
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
     * Set dtReajuste
     *
     * @param \DateTime $dtReajuste
     * @return Reajuste
     */
    public function setDtReajuste(\DateTime $dtReajuste)
    {
        $this->dtReajuste = $dtReajuste;
        return $this;
    }

    /**
     * Get dtReajuste
     *
     * @return \DateTime
     */
    public function getDtReajuste()
    {
        return $this->dtReajuste;
    }

    /**
     * Set faixaInicial
     *
     * @param integer $faixaInicial
     * @return Reajuste
     */
    public function setFaixaInicial($faixaInicial)
    {
        $this->faixaInicial = $faixaInicial;
        return $this;
    }

    /**
     * Get faixaInicial
     *
     * @return integer
     */
    public function getFaixaInicial()
    {
        return $this->faixaInicial;
    }

    /**
     * Set faixaFinal
     *
     * @param integer $faixaFinal
     * @return Reajuste
     */
    public function setFaixaFinal($faixaFinal)
    {
        $this->faixaFinal = $faixaFinal;
        return $this;
    }

    /**
     * Get faixaFinal
     *
     * @return integer
     */
    public function getFaixaFinal()
    {
        return $this->faixaFinal;
    }

    /**
     * Set origem
     *
     * @param string $origem
     * @return Reajuste
     */
    public function setOrigem($origem)
    {
        $this->origem = $origem;
        return $this;
    }

    /**
     * Get origem
     *
     * @return string
     */
    public function getOrigem()
    {
        return $this->origem;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario $fkFolhapagamentoReajusteContratoServidorSalario
     * @return Reajuste
     */
    public function addFkFolhapagamentoReajusteContratoServidorSalarios(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario $fkFolhapagamentoReajusteContratoServidorSalario)
    {
        if (false === $this->fkFolhapagamentoReajusteContratoServidorSalarios->contains($fkFolhapagamentoReajusteContratoServidorSalario)) {
            $fkFolhapagamentoReajusteContratoServidorSalario->setFkFolhapagamentoReajuste($this);
            $this->fkFolhapagamentoReajusteContratoServidorSalarios->add($fkFolhapagamentoReajusteContratoServidorSalario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteContratoServidorSalario
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario $fkFolhapagamentoReajusteContratoServidorSalario
     */
    public function removeFkFolhapagamentoReajusteContratoServidorSalarios(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario $fkFolhapagamentoReajusteContratoServidorSalario)
    {
        $this->fkFolhapagamentoReajusteContratoServidorSalarios->removeElement($fkFolhapagamentoReajusteContratoServidorSalario);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteContratoServidorSalarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteContratoServidorSalario
     */
    public function getFkFolhapagamentoReajusteContratoServidorSalarios()
    {
        return $this->fkFolhapagamentoReajusteContratoServidorSalarios;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajustePadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao $fkFolhapagamentoReajustePadraoPadrao
     * @return Reajuste
     */
    public function addFkFolhapagamentoReajustePadraoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao $fkFolhapagamentoReajustePadraoPadrao)
    {
        if (false === $this->fkFolhapagamentoReajustePadraoPadroes->contains($fkFolhapagamentoReajustePadraoPadrao)) {
            $fkFolhapagamentoReajustePadraoPadrao->setFkFolhapagamentoReajuste($this);
            $this->fkFolhapagamentoReajustePadraoPadroes->add($fkFolhapagamentoReajustePadraoPadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajustePadraoPadrao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao $fkFolhapagamentoReajustePadraoPadrao
     */
    public function removeFkFolhapagamentoReajustePadraoPadroes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao $fkFolhapagamentoReajustePadraoPadrao)
    {
        $this->fkFolhapagamentoReajustePadraoPadroes->removeElement($fkFolhapagamentoReajustePadraoPadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajustePadraoPadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePadraoPadrao
     */
    public function getFkFolhapagamentoReajustePadraoPadroes()
    {
        return $this->fkFolhapagamentoReajustePadraoPadroes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo $fkFolhapagamentoReajusteRegistroEventoDecimo
     * @return Reajuste
     */
    public function addFkFolhapagamentoReajusteRegistroEventoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo $fkFolhapagamentoReajusteRegistroEventoDecimo)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventoDecimos->contains($fkFolhapagamentoReajusteRegistroEventoDecimo)) {
            $fkFolhapagamentoReajusteRegistroEventoDecimo->setFkFolhapagamentoReajuste($this);
            $this->fkFolhapagamentoReajusteRegistroEventoDecimos->add($fkFolhapagamentoReajusteRegistroEventoDecimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEventoDecimo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo $fkFolhapagamentoReajusteRegistroEventoDecimo
     */
    public function removeFkFolhapagamentoReajusteRegistroEventoDecimos(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo $fkFolhapagamentoReajusteRegistroEventoDecimo)
    {
        $this->fkFolhapagamentoReajusteRegistroEventoDecimos->removeElement($fkFolhapagamentoReajusteRegistroEventoDecimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventoDecimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoDecimo
     */
    public function getFkFolhapagamentoReajusteRegistroEventoDecimos()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventoDecimos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias $fkFolhapagamentoReajusteRegistroEventoFerias
     * @return Reajuste
     */
    public function addFkFolhapagamentoReajusteRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias $fkFolhapagamentoReajusteRegistroEventoFerias)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventoFerias->contains($fkFolhapagamentoReajusteRegistroEventoFerias)) {
            $fkFolhapagamentoReajusteRegistroEventoFerias->setFkFolhapagamentoReajuste($this);
            $this->fkFolhapagamentoReajusteRegistroEventoFerias->add($fkFolhapagamentoReajusteRegistroEventoFerias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEventoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias $fkFolhapagamentoReajusteRegistroEventoFerias
     */
    public function removeFkFolhapagamentoReajusteRegistroEventoFerias(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias $fkFolhapagamentoReajusteRegistroEventoFerias)
    {
        $this->fkFolhapagamentoReajusteRegistroEventoFerias->removeElement($fkFolhapagamentoReajusteRegistroEventoFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventoFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoFerias
     */
    public function getFkFolhapagamentoReajusteRegistroEventoFerias()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventoFerias;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao $fkFolhapagamentoReajusteRegistroEventoRescisao
     * @return Reajuste
     */
    public function addFkFolhapagamentoReajusteRegistroEventoRescisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao $fkFolhapagamentoReajusteRegistroEventoRescisao)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventoRescisoes->contains($fkFolhapagamentoReajusteRegistroEventoRescisao)) {
            $fkFolhapagamentoReajusteRegistroEventoRescisao->setFkFolhapagamentoReajuste($this);
            $this->fkFolhapagamentoReajusteRegistroEventoRescisoes->add($fkFolhapagamentoReajusteRegistroEventoRescisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEventoRescisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao $fkFolhapagamentoReajusteRegistroEventoRescisao
     */
    public function removeFkFolhapagamentoReajusteRegistroEventoRescisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao $fkFolhapagamentoReajusteRegistroEventoRescisao)
    {
        $this->fkFolhapagamentoReajusteRegistroEventoRescisoes->removeElement($fkFolhapagamentoReajusteRegistroEventoRescisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventoRescisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoRescisao
     */
    public function getFkFolhapagamentoReajusteRegistroEventoRescisoes()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventoRescisoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar $fkFolhapagamentoReajusteRegistroEventoComplementar
     * @return Reajuste
     */
    public function addFkFolhapagamentoReajusteRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar $fkFolhapagamentoReajusteRegistroEventoComplementar)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventoComplementares->contains($fkFolhapagamentoReajusteRegistroEventoComplementar)) {
            $fkFolhapagamentoReajusteRegistroEventoComplementar->setFkFolhapagamentoReajuste($this);
            $this->fkFolhapagamentoReajusteRegistroEventoComplementares->add($fkFolhapagamentoReajusteRegistroEventoComplementar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar $fkFolhapagamentoReajusteRegistroEventoComplementar
     */
    public function removeFkFolhapagamentoReajusteRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar $fkFolhapagamentoReajusteRegistroEventoComplementar)
    {
        $this->fkFolhapagamentoReajusteRegistroEventoComplementares->removeElement($fkFolhapagamentoReajusteRegistroEventoComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventoComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEventoComplementar
     */
    public function getFkFolhapagamentoReajusteRegistroEventoComplementares()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventoComplementares;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoReajusteRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento $fkFolhapagamentoReajusteRegistroEvento
     * @return Reajuste
     */
    public function addFkFolhapagamentoReajusteRegistroEventos(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento $fkFolhapagamentoReajusteRegistroEvento)
    {
        if (false === $this->fkFolhapagamentoReajusteRegistroEventos->contains($fkFolhapagamentoReajusteRegistroEvento)) {
            $fkFolhapagamentoReajusteRegistroEvento->setFkFolhapagamentoReajuste($this);
            $this->fkFolhapagamentoReajusteRegistroEventos->add($fkFolhapagamentoReajusteRegistroEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoReajusteRegistroEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento $fkFolhapagamentoReajusteRegistroEvento
     */
    public function removeFkFolhapagamentoReajusteRegistroEventos(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento $fkFolhapagamentoReajusteRegistroEvento)
    {
        $this->fkFolhapagamentoReajusteRegistroEventos->removeElement($fkFolhapagamentoReajusteRegistroEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoReajusteRegistroEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteRegistroEvento
     */
    public function getFkFolhapagamentoReajusteRegistroEventos()
    {
        return $this->fkFolhapagamentoReajusteRegistroEventos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return Reajuste
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoReajusteExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao $fkFolhapagamentoReajusteExclusao
     * @return Reajuste
     */
    public function setFkFolhapagamentoReajusteExclusao(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao $fkFolhapagamentoReajusteExclusao)
    {
        $fkFolhapagamentoReajusteExclusao->setFkFolhapagamentoReajuste($this);
        $this->fkFolhapagamentoReajusteExclusao = $fkFolhapagamentoReajusteExclusao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoReajusteExclusao
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteExclusao
     */
    public function getFkFolhapagamentoReajusteExclusao()
    {
        return $this->fkFolhapagamentoReajusteExclusao;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoReajustePercentual
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajustePercentual $fkFolhapagamentoReajustePercentual
     * @return Reajuste
     */
    public function setFkFolhapagamentoReajustePercentual(\Urbem\CoreBundle\Entity\Folhapagamento\ReajustePercentual $fkFolhapagamentoReajustePercentual)
    {
        $fkFolhapagamentoReajustePercentual->setFkFolhapagamentoReajuste($this);
        $this->fkFolhapagamentoReajustePercentual = $fkFolhapagamentoReajustePercentual;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoReajustePercentual
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ReajustePercentual
     */
    public function getFkFolhapagamentoReajustePercentual()
    {
        return $this->fkFolhapagamentoReajustePercentual;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoReajusteAbsoluto
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteAbsoluto $fkFolhapagamentoReajusteAbsoluto
     * @return Reajuste
     */
    public function setFkFolhapagamentoReajusteAbsoluto(\Urbem\CoreBundle\Entity\Folhapagamento\ReajusteAbsoluto $fkFolhapagamentoReajusteAbsoluto)
    {
        $fkFolhapagamentoReajusteAbsoluto->setFkFolhapagamentoReajuste($this);
        $this->fkFolhapagamentoReajusteAbsoluto = $fkFolhapagamentoReajusteAbsoluto;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoReajusteAbsoluto
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ReajusteAbsoluto
     */
    public function getFkFolhapagamentoReajusteAbsoluto()
    {
        return $this->fkFolhapagamentoReajusteAbsoluto;
    }
}
