<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * FaturamentoServico
 */
class FaturamentoServico
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $competencia;

    /**
     * PK
     * @var integer
     */
    private $codServico;

    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $ocorrencia;

    /**
     * @var integer
     */
    private $codModalidade;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoSemRetencao
     */
    private $fkFiscalizacaoServicoSemRetencao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotaServico
     */
    private $fkFiscalizacaoNotaServicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao
     */
    private $fkFiscalizacaoServicoComRetencoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento
     */
    private $fkFiscalizacaoProcessoLevantamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ServicoAtividade
     */
    private $fkEconomicoServicoAtividade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento
     */
    private $fkEconomicoModalidadeLancamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoNotaServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoServicoComRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return FaturamentoServico
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
     * Set competencia
     *
     * @param string $competencia
     * @return FaturamentoServico
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set codServico
     *
     * @param integer $codServico
     * @return FaturamentoServico
     */
    public function setCodServico($codServico)
    {
        $this->codServico = $codServico;
        return $this;
    }

    /**
     * Get codServico
     *
     * @return integer
     */
    public function getCodServico()
    {
        return $this->codServico;
    }

    /**
     * Set codAtividade
     *
     * @param integer $codAtividade
     * @return FaturamentoServico
     */
    public function setCodAtividade($codAtividade)
    {
        $this->codAtividade = $codAtividade;
        return $this;
    }

    /**
     * Get codAtividade
     *
     * @return integer
     */
    public function getCodAtividade()
    {
        return $this->codAtividade;
    }

    /**
     * Set ocorrencia
     *
     * @param integer $ocorrencia
     * @return FaturamentoServico
     */
    public function setOcorrencia($ocorrencia)
    {
        $this->ocorrencia = $ocorrencia;
        return $this;
    }

    /**
     * Get ocorrencia
     *
     * @return integer
     */
    public function getOcorrencia()
    {
        return $this->ocorrencia;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return FaturamentoServico
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return FaturamentoServico
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotaServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotaServico $fkFiscalizacaoNotaServico
     * @return FaturamentoServico
     */
    public function addFkFiscalizacaoNotaServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\NotaServico $fkFiscalizacaoNotaServico)
    {
        if (false === $this->fkFiscalizacaoNotaServicos->contains($fkFiscalizacaoNotaServico)) {
            $fkFiscalizacaoNotaServico->setFkFiscalizacaoFaturamentoServico($this);
            $this->fkFiscalizacaoNotaServicos->add($fkFiscalizacaoNotaServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotaServico
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotaServico $fkFiscalizacaoNotaServico
     */
    public function removeFkFiscalizacaoNotaServicos(\Urbem\CoreBundle\Entity\Fiscalizacao\NotaServico $fkFiscalizacaoNotaServico)
    {
        $this->fkFiscalizacaoNotaServicos->removeElement($fkFiscalizacaoNotaServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotaServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotaServico
     */
    public function getFkFiscalizacaoNotaServicos()
    {
        return $this->fkFiscalizacaoNotaServicos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao
     * @return FaturamentoServico
     */
    public function addFkFiscalizacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao)
    {
        if (false === $this->fkFiscalizacaoServicoComRetencoes->contains($fkFiscalizacaoServicoComRetencao)) {
            $fkFiscalizacaoServicoComRetencao->setFkFiscalizacaoFaturamentoServico($this);
            $this->fkFiscalizacaoServicoComRetencoes->add($fkFiscalizacaoServicoComRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao
     */
    public function removeFkFiscalizacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao $fkFiscalizacaoServicoComRetencao)
    {
        $this->fkFiscalizacaoServicoComRetencoes->removeElement($fkFiscalizacaoServicoComRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoServicoComRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoComRetencao
     */
    public function getFkFiscalizacaoServicoComRetencoes()
    {
        return $this->fkFiscalizacaoServicoComRetencoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoProcessoLevantamento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento
     * @return FaturamentoServico
     */
    public function setFkFiscalizacaoProcessoLevantamento(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoLevantamento->getCodProcesso();
        $this->competencia = $fkFiscalizacaoProcessoLevantamento->getCompetencia();
        $this->fkFiscalizacaoProcessoLevantamento = $fkFiscalizacaoProcessoLevantamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoProcessoLevantamento
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento
     */
    public function getFkFiscalizacaoProcessoLevantamento()
    {
        return $this->fkFiscalizacaoProcessoLevantamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoServicoAtividade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade
     * @return FaturamentoServico
     */
    public function setFkEconomicoServicoAtividade(\Urbem\CoreBundle\Entity\Economico\ServicoAtividade $fkEconomicoServicoAtividade)
    {
        $this->codServico = $fkEconomicoServicoAtividade->getCodServico();
        $this->codAtividade = $fkEconomicoServicoAtividade->getCodAtividade();
        $this->fkEconomicoServicoAtividade = $fkEconomicoServicoAtividade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoServicoAtividade
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ServicoAtividade
     */
    public function getFkEconomicoServicoAtividade()
    {
        return $this->fkEconomicoServicoAtividade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoModalidadeLancamento
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento $fkEconomicoModalidadeLancamento
     * @return FaturamentoServico
     */
    public function setFkEconomicoModalidadeLancamento(\Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento $fkEconomicoModalidadeLancamento)
    {
        $this->codModalidade = $fkEconomicoModalidadeLancamento->getCodModalidade();
        $this->fkEconomicoModalidadeLancamento = $fkEconomicoModalidadeLancamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoModalidadeLancamento
     *
     * @return \Urbem\CoreBundle\Entity\Economico\ModalidadeLancamento
     */
    public function getFkEconomicoModalidadeLancamento()
    {
        return $this->fkEconomicoModalidadeLancamento;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoServicoSemRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoSemRetencao $fkFiscalizacaoServicoSemRetencao
     * @return FaturamentoServico
     */
    public function setFkFiscalizacaoServicoSemRetencao(\Urbem\CoreBundle\Entity\Fiscalizacao\ServicoSemRetencao $fkFiscalizacaoServicoSemRetencao)
    {
        $fkFiscalizacaoServicoSemRetencao->setFkFiscalizacaoFaturamentoServico($this);
        $this->fkFiscalizacaoServicoSemRetencao = $fkFiscalizacaoServicoSemRetencao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoServicoSemRetencao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ServicoSemRetencao
     */
    public function getFkFiscalizacaoServicoSemRetencao()
    {
        return $this->fkFiscalizacaoServicoSemRetencao;
    }
}
