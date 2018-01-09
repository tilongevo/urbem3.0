<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Especialidade
 */
class Especialidade
{
    /**
     * PK
     * @var integer
     */
    private $codEspecialidade;

    /**
     * @var integer
     */
    private $codCargo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade
     */
    private $fkFolhapagamentoConfiguracaoEventoCasoEspecialidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade
     */
    private $fkPessoalCboEspecialidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao
     */
    private $fkPessoalContratoServidorEspecialidadeFuncoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo
     */
    private $fkPessoalContratoServidorEspecialidadeCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao
     */
    private $fkPessoalEspecialidadePadroes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao
     */
    private $fkPessoalEspecialidadeSubDivisoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalCboEspecialidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorEspecialidadeFuncoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorEspecialidadeCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalEspecialidadePadroes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalEspecialidadeSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codEspecialidade
     *
     * @param integer $codEspecialidade
     * @return Especialidade
     */
    public function setCodEspecialidade($codEspecialidade)
    {
        $this->codEspecialidade = $codEspecialidade;
        return $this;
    }

    /**
     * Get codEspecialidade
     *
     * @return integer
     */
    public function getCodEspecialidade()
    {
        return $this->codEspecialidade;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return Especialidade
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Especialidade
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventoCasoEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade
     * @return Especialidade
     */
    public function addFkFolhapagamentoConfiguracaoEventoCasoEspecialidades(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades->contains($fkFolhapagamentoConfiguracaoEventoCasoEspecialidade)) {
            $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade->setFkPessoalEspecialidade($this);
            $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades->add($fkFolhapagamentoConfiguracaoEventoCasoEspecialidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoCasoEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade
     */
    public function removeFkFolhapagamentoConfiguracaoEventoCasoEspecialidades(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade)
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades->removeElement($fkFolhapagamentoConfiguracaoEventoCasoEspecialidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCasoEspecialidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasoEspecialidades()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalCboEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade $fkPessoalCboEspecialidade
     * @return Especialidade
     */
    public function addFkPessoalCboEspecialidades(\Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade $fkPessoalCboEspecialidade)
    {
        if (false === $this->fkPessoalCboEspecialidades->contains($fkPessoalCboEspecialidade)) {
            $fkPessoalCboEspecialidade->setFkPessoalEspecialidade($this);
            $this->fkPessoalCboEspecialidades->add($fkPessoalCboEspecialidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCboEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade $fkPessoalCboEspecialidade
     */
    public function removeFkPessoalCboEspecialidades(\Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade $fkPessoalCboEspecialidade)
    {
        $this->fkPessoalCboEspecialidades->removeElement($fkPessoalCboEspecialidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCboEspecialidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CboEspecialidade
     */
    public function getFkPessoalCboEspecialidades()
    {
        return $this->fkPessoalCboEspecialidades;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorEspecialidadeFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao $fkPessoalContratoServidorEspecialidadeFuncao
     * @return Especialidade
     */
    public function addFkPessoalContratoServidorEspecialidadeFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao $fkPessoalContratoServidorEspecialidadeFuncao)
    {
        if (false === $this->fkPessoalContratoServidorEspecialidadeFuncoes->contains($fkPessoalContratoServidorEspecialidadeFuncao)) {
            $fkPessoalContratoServidorEspecialidadeFuncao->setFkPessoalEspecialidade($this);
            $this->fkPessoalContratoServidorEspecialidadeFuncoes->add($fkPessoalContratoServidorEspecialidadeFuncao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorEspecialidadeFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao $fkPessoalContratoServidorEspecialidadeFuncao
     */
    public function removeFkPessoalContratoServidorEspecialidadeFuncoes(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao $fkPessoalContratoServidorEspecialidadeFuncao)
    {
        $this->fkPessoalContratoServidorEspecialidadeFuncoes->removeElement($fkPessoalContratoServidorEspecialidadeFuncao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorEspecialidadeFuncoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeFuncao
     */
    public function getFkPessoalContratoServidorEspecialidadeFuncoes()
    {
        return $this->fkPessoalContratoServidorEspecialidadeFuncoes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorEspecialidadeCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo $fkPessoalContratoServidorEspecialidadeCargo
     * @return Especialidade
     */
    public function addFkPessoalContratoServidorEspecialidadeCargos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo $fkPessoalContratoServidorEspecialidadeCargo)
    {
        if (false === $this->fkPessoalContratoServidorEspecialidadeCargos->contains($fkPessoalContratoServidorEspecialidadeCargo)) {
            $fkPessoalContratoServidorEspecialidadeCargo->setFkPessoalEspecialidade($this);
            $this->fkPessoalContratoServidorEspecialidadeCargos->add($fkPessoalContratoServidorEspecialidadeCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorEspecialidadeCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo $fkPessoalContratoServidorEspecialidadeCargo
     */
    public function removeFkPessoalContratoServidorEspecialidadeCargos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo $fkPessoalContratoServidorEspecialidadeCargo)
    {
        $this->fkPessoalContratoServidorEspecialidadeCargos->removeElement($fkPessoalContratoServidorEspecialidadeCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorEspecialidadeCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorEspecialidadeCargo
     */
    public function getFkPessoalContratoServidorEspecialidadeCargos()
    {
        return $this->fkPessoalContratoServidorEspecialidadeCargos;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalEspecialidadePadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao $fkPessoalEspecialidadePadrao
     * @return Especialidade
     */
    public function addFkPessoalEspecialidadePadroes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao $fkPessoalEspecialidadePadrao)
    {
        if (false === $this->fkPessoalEspecialidadePadroes->contains($fkPessoalEspecialidadePadrao)) {
            $fkPessoalEspecialidadePadrao->setFkPessoalEspecialidade($this);
            $this->fkPessoalEspecialidadePadroes->add($fkPessoalEspecialidadePadrao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalEspecialidadePadrao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao $fkPessoalEspecialidadePadrao
     */
    public function removeFkPessoalEspecialidadePadroes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao $fkPessoalEspecialidadePadrao)
    {
        $this->fkPessoalEspecialidadePadroes->removeElement($fkPessoalEspecialidadePadrao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalEspecialidadePadroes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadePadrao
     */
    public function getFkPessoalEspecialidadePadroes()
    {
        return $this->fkPessoalEspecialidadePadroes;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalEspecialidadeSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao
     * @return Especialidade
     */
    public function addFkPessoalEspecialidadeSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao)
    {
        if (false === $this->fkPessoalEspecialidadeSubDivisoes->contains($fkPessoalEspecialidadeSubDivisao)) {
            $fkPessoalEspecialidadeSubDivisao->setFkPessoalEspecialidade($this);
            $this->fkPessoalEspecialidadeSubDivisoes->add($fkPessoalEspecialidadeSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalEspecialidadeSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao
     */
    public function removeFkPessoalEspecialidadeSubDivisoes(\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao $fkPessoalEspecialidadeSubDivisao)
    {
        $this->fkPessoalEspecialidadeSubDivisoes->removeElement($fkPessoalEspecialidadeSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalEspecialidadeSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\EspecialidadeSubDivisao
     */
    public function getFkPessoalEspecialidadeSubDivisoes()
    {
        return $this->fkPessoalEspecialidadeSubDivisoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return Especialidade
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }

    public function __toString()
    {
        return (string) $this->descricao;
    }
}
