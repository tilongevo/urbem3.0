<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwPreEmpenho
 */
class SwPreEmpenho
{
    /**
     * PK
     * @var integer
     */
    private $codPreEmpenho;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $cgmUsuario;

    /**
     * @var integer
     */
    private $cgmBeneficiario;

    /**
     * @var integer
     */
    private $codHistorico;

    /**
     * @var integer
     */
    private $codCategoriaEconomica;

    /**
     * @var integer
     */
    private $codGrupoDespesa;

    /**
     * @var integer
     */
    private $codModalidadeAplicacao;

    /**
     * @var integer
     */
    private $codElementoDespesa;

    /**
     * @var integer
     */
    private $codDesdobramento1;

    /**
     * @var integer
     */
    private $codDesdobramento2;

    /**
     * @var integer
     */
    private $codDesdobramento3;

    /**
     * @var integer
     */
    private $codDespesa;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho
     */
    private $fkSwAutorizacaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEmpenho
     */
    private $fkSwEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho
     */
    private $fkSwValorAtributoPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwItemPreEmpenho
     */
    private $fkSwItemPreEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenhoOrdem
     */
    private $fkSwPreEmpenhoOrdens;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwHistoricoClassificacao
     */
    private $fkSwHistoricoClassificacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwTipoEmpenho
     */
    private $fkSwTipoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwAutorizacaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwValorAtributoPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwItemPreEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwPreEmpenhoOrdens = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPreEmpenho
     *
     * @param integer $codPreEmpenho
     * @return SwPreEmpenho
     */
    public function setCodPreEmpenho($codPreEmpenho)
    {
        $this->codPreEmpenho = $codPreEmpenho;
        return $this;
    }

    /**
     * Get codPreEmpenho
     *
     * @return integer
     */
    public function getCodPreEmpenho()
    {
        return $this->codPreEmpenho;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return SwPreEmpenho
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
     * Set descricao
     *
     * @param string $descricao
     * @return SwPreEmpenho
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return SwPreEmpenho
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
     * Set cgmUsuario
     *
     * @param integer $cgmUsuario
     * @return SwPreEmpenho
     */
    public function setCgmUsuario($cgmUsuario)
    {
        $this->cgmUsuario = $cgmUsuario;
        return $this;
    }

    /**
     * Get cgmUsuario
     *
     * @return integer
     */
    public function getCgmUsuario()
    {
        return $this->cgmUsuario;
    }

    /**
     * Set cgmBeneficiario
     *
     * @param integer $cgmBeneficiario
     * @return SwPreEmpenho
     */
    public function setCgmBeneficiario($cgmBeneficiario)
    {
        $this->cgmBeneficiario = $cgmBeneficiario;
        return $this;
    }

    /**
     * Get cgmBeneficiario
     *
     * @return integer
     */
    public function getCgmBeneficiario()
    {
        return $this->cgmBeneficiario;
    }

    /**
     * Set codHistorico
     *
     * @param integer $codHistorico
     * @return SwPreEmpenho
     */
    public function setCodHistorico($codHistorico)
    {
        $this->codHistorico = $codHistorico;
        return $this;
    }

    /**
     * Get codHistorico
     *
     * @return integer
     */
    public function getCodHistorico()
    {
        return $this->codHistorico;
    }

    /**
     * Set codCategoriaEconomica
     *
     * @param integer $codCategoriaEconomica
     * @return SwPreEmpenho
     */
    public function setCodCategoriaEconomica($codCategoriaEconomica)
    {
        $this->codCategoriaEconomica = $codCategoriaEconomica;
        return $this;
    }

    /**
     * Get codCategoriaEconomica
     *
     * @return integer
     */
    public function getCodCategoriaEconomica()
    {
        return $this->codCategoriaEconomica;
    }

    /**
     * Set codGrupoDespesa
     *
     * @param integer $codGrupoDespesa
     * @return SwPreEmpenho
     */
    public function setCodGrupoDespesa($codGrupoDespesa)
    {
        $this->codGrupoDespesa = $codGrupoDespesa;
        return $this;
    }

    /**
     * Get codGrupoDespesa
     *
     * @return integer
     */
    public function getCodGrupoDespesa()
    {
        return $this->codGrupoDespesa;
    }

    /**
     * Set codModalidadeAplicacao
     *
     * @param integer $codModalidadeAplicacao
     * @return SwPreEmpenho
     */
    public function setCodModalidadeAplicacao($codModalidadeAplicacao)
    {
        $this->codModalidadeAplicacao = $codModalidadeAplicacao;
        return $this;
    }

    /**
     * Get codModalidadeAplicacao
     *
     * @return integer
     */
    public function getCodModalidadeAplicacao()
    {
        return $this->codModalidadeAplicacao;
    }

    /**
     * Set codElementoDespesa
     *
     * @param integer $codElementoDespesa
     * @return SwPreEmpenho
     */
    public function setCodElementoDespesa($codElementoDespesa)
    {
        $this->codElementoDespesa = $codElementoDespesa;
        return $this;
    }

    /**
     * Get codElementoDespesa
     *
     * @return integer
     */
    public function getCodElementoDespesa()
    {
        return $this->codElementoDespesa;
    }

    /**
     * Set codDesdobramento1
     *
     * @param integer $codDesdobramento1
     * @return SwPreEmpenho
     */
    public function setCodDesdobramento1($codDesdobramento1)
    {
        $this->codDesdobramento1 = $codDesdobramento1;
        return $this;
    }

    /**
     * Get codDesdobramento1
     *
     * @return integer
     */
    public function getCodDesdobramento1()
    {
        return $this->codDesdobramento1;
    }

    /**
     * Set codDesdobramento2
     *
     * @param integer $codDesdobramento2
     * @return SwPreEmpenho
     */
    public function setCodDesdobramento2($codDesdobramento2)
    {
        $this->codDesdobramento2 = $codDesdobramento2;
        return $this;
    }

    /**
     * Get codDesdobramento2
     *
     * @return integer
     */
    public function getCodDesdobramento2()
    {
        return $this->codDesdobramento2;
    }

    /**
     * Set codDesdobramento3
     *
     * @param integer $codDesdobramento3
     * @return SwPreEmpenho
     */
    public function setCodDesdobramento3($codDesdobramento3)
    {
        $this->codDesdobramento3 = $codDesdobramento3;
        return $this;
    }

    /**
     * Get codDesdobramento3
     *
     * @return integer
     */
    public function getCodDesdobramento3()
    {
        return $this->codDesdobramento3;
    }

    /**
     * Set codDespesa
     *
     * @param integer $codDespesa
     * @return SwPreEmpenho
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
     * OneToMany (owning side)
     * Add SwAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho $fkSwAutorizacaoEmpenho
     * @return SwPreEmpenho
     */
    public function addFkSwAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho $fkSwAutorizacaoEmpenho)
    {
        if (false === $this->fkSwAutorizacaoEmpenhos->contains($fkSwAutorizacaoEmpenho)) {
            $fkSwAutorizacaoEmpenho->setFkSwPreEmpenho($this);
            $this->fkSwAutorizacaoEmpenhos->add($fkSwAutorizacaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho $fkSwAutorizacaoEmpenho
     */
    public function removeFkSwAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho $fkSwAutorizacaoEmpenho)
    {
        $this->fkSwAutorizacaoEmpenhos->removeElement($fkSwAutorizacaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAutorizacaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAutorizacaoEmpenho
     */
    public function getFkSwAutorizacaoEmpenhos()
    {
        return $this->fkSwAutorizacaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add SwEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho
     * @return SwPreEmpenho
     */
    public function addFkSwEmpenhos(\Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho)
    {
        if (false === $this->fkSwEmpenhos->contains($fkSwEmpenho)) {
            $fkSwEmpenho->setFkSwPreEmpenho($this);
            $this->fkSwEmpenhos->add($fkSwEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho
     */
    public function removeFkSwEmpenhos(\Urbem\CoreBundle\Entity\SwEmpenho $fkSwEmpenho)
    {
        $this->fkSwEmpenhos->removeElement($fkSwEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwEmpenho
     */
    public function getFkSwEmpenhos()
    {
        return $this->fkSwEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add SwValorAtributoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho $fkSwValorAtributoPreEmpenho
     * @return SwPreEmpenho
     */
    public function addFkSwValorAtributoPreEmpenhos(\Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho $fkSwValorAtributoPreEmpenho)
    {
        if (false === $this->fkSwValorAtributoPreEmpenhos->contains($fkSwValorAtributoPreEmpenho)) {
            $fkSwValorAtributoPreEmpenho->setFkSwPreEmpenho($this);
            $this->fkSwValorAtributoPreEmpenhos->add($fkSwValorAtributoPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwValorAtributoPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho $fkSwValorAtributoPreEmpenho
     */
    public function removeFkSwValorAtributoPreEmpenhos(\Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho $fkSwValorAtributoPreEmpenho)
    {
        $this->fkSwValorAtributoPreEmpenhos->removeElement($fkSwValorAtributoPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwValorAtributoPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwValorAtributoPreEmpenho
     */
    public function getFkSwValorAtributoPreEmpenhos()
    {
        return $this->fkSwValorAtributoPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add SwItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho
     * @return SwPreEmpenho
     */
    public function addFkSwItemPreEmpenhos(\Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho)
    {
        if (false === $this->fkSwItemPreEmpenhos->contains($fkSwItemPreEmpenho)) {
            $fkSwItemPreEmpenho->setFkSwPreEmpenho($this);
            $this->fkSwItemPreEmpenhos->add($fkSwItemPreEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwItemPreEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho
     */
    public function removeFkSwItemPreEmpenhos(\Urbem\CoreBundle\Entity\SwItemPreEmpenho $fkSwItemPreEmpenho)
    {
        $this->fkSwItemPreEmpenhos->removeElement($fkSwItemPreEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwItemPreEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwItemPreEmpenho
     */
    public function getFkSwItemPreEmpenhos()
    {
        return $this->fkSwItemPreEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add SwPreEmpenhoOrdem
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenhoOrdem $fkSwPreEmpenhoOrdem
     * @return SwPreEmpenho
     */
    public function addFkSwPreEmpenhoOrdens(\Urbem\CoreBundle\Entity\SwPreEmpenhoOrdem $fkSwPreEmpenhoOrdem)
    {
        if (false === $this->fkSwPreEmpenhoOrdens->contains($fkSwPreEmpenhoOrdem)) {
            $fkSwPreEmpenhoOrdem->setFkSwPreEmpenho($this);
            $this->fkSwPreEmpenhoOrdens->add($fkSwPreEmpenhoOrdem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwPreEmpenhoOrdem
     *
     * @param \Urbem\CoreBundle\Entity\SwPreEmpenhoOrdem $fkSwPreEmpenhoOrdem
     */
    public function removeFkSwPreEmpenhoOrdens(\Urbem\CoreBundle\Entity\SwPreEmpenhoOrdem $fkSwPreEmpenhoOrdem)
    {
        $this->fkSwPreEmpenhoOrdens->removeElement($fkSwPreEmpenhoOrdem);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwPreEmpenhoOrdens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwPreEmpenhoOrdem
     */
    public function getFkSwPreEmpenhoOrdens()
    {
        return $this->fkSwPreEmpenhoOrdens;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwHistoricoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\SwHistoricoClassificacao $fkSwHistoricoClassificacao
     * @return SwPreEmpenho
     */
    public function setFkSwHistoricoClassificacao(\Urbem\CoreBundle\Entity\SwHistoricoClassificacao $fkSwHistoricoClassificacao)
    {
        $this->codHistorico = $fkSwHistoricoClassificacao->getCodHistoricoClassificacao();
        $this->exercicio = $fkSwHistoricoClassificacao->getExercicio();
        $this->fkSwHistoricoClassificacao = $fkSwHistoricoClassificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwHistoricoClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\SwHistoricoClassificacao
     */
    public function getFkSwHistoricoClassificacao()
    {
        return $this->fkSwHistoricoClassificacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwTipoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\SwTipoEmpenho $fkSwTipoEmpenho
     * @return SwPreEmpenho
     */
    public function setFkSwTipoEmpenho(\Urbem\CoreBundle\Entity\SwTipoEmpenho $fkSwTipoEmpenho)
    {
        $this->codTipo = $fkSwTipoEmpenho->getCodTipo();
        $this->fkSwTipoEmpenho = $fkSwTipoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwTipoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\SwTipoEmpenho
     */
    public function getFkSwTipoEmpenho()
    {
        return $this->fkSwTipoEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return SwPreEmpenho
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->cgmUsuario = $fkAdministracaoUsuario->getNumcgm();
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
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return SwPreEmpenho
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->cgmBeneficiario = $fkSwCgm->getNumcgm();
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
