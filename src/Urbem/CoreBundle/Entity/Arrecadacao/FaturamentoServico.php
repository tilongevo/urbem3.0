<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * FaturamentoServico
 */
class FaturamentoServico
{
    /**
     * PK
     * @var integer
     */
    private $codAtividade;

    /**
     * PK
     * @var integer
     */
    private $codServico;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

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
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ServicoSemRetencao
     */
    private $fkArrecadacaoServicoSemRetencao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaServico
     */
    private $fkArrecadacaoNotaServicos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao
     */
    private $fkArrecadacaoServicoComRetencoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\ServicoAtividade
     */
    private $fkEconomicoServicoAtividade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento
     */
    private $fkArrecadacaoCadastroEconomicoFaturamento;

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
        $this->fkArrecadacaoNotaServicos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoServicoComRetencoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
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
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return FaturamentoServico
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return FaturamentoServico
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
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
     * Add ArrecadacaoNotaServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaServico $fkArrecadacaoNotaServico
     * @return FaturamentoServico
     */
    public function addFkArrecadacaoNotaServicos(\Urbem\CoreBundle\Entity\Arrecadacao\NotaServico $fkArrecadacaoNotaServico)
    {
        if (false === $this->fkArrecadacaoNotaServicos->contains($fkArrecadacaoNotaServico)) {
            $fkArrecadacaoNotaServico->setFkArrecadacaoFaturamentoServico($this);
            $this->fkArrecadacaoNotaServicos->add($fkArrecadacaoNotaServico);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoNotaServico
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\NotaServico $fkArrecadacaoNotaServico
     */
    public function removeFkArrecadacaoNotaServicos(\Urbem\CoreBundle\Entity\Arrecadacao\NotaServico $fkArrecadacaoNotaServico)
    {
        $this->fkArrecadacaoNotaServicos->removeElement($fkArrecadacaoNotaServico);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoNotaServicos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\NotaServico
     */
    public function getFkArrecadacaoNotaServicos()
    {
        return $this->fkArrecadacaoNotaServicos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao
     * @return FaturamentoServico
     */
    public function addFkArrecadacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao)
    {
        if (false === $this->fkArrecadacaoServicoComRetencoes->contains($fkArrecadacaoServicoComRetencao)) {
            $fkArrecadacaoServicoComRetencao->setFkArrecadacaoFaturamentoServico($this);
            $this->fkArrecadacaoServicoComRetencoes->add($fkArrecadacaoServicoComRetencao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoServicoComRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao
     */
    public function removeFkArrecadacaoServicoComRetencoes(\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao $fkArrecadacaoServicoComRetencao)
    {
        $this->fkArrecadacaoServicoComRetencoes->removeElement($fkArrecadacaoServicoComRetencao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoServicoComRetencoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ServicoComRetencao
     */
    public function getFkArrecadacaoServicoComRetencoes()
    {
        return $this->fkArrecadacaoServicoComRetencoes;
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
     * Set fkArrecadacaoCadastroEconomicoFaturamento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento
     * @return FaturamentoServico
     */
    public function setFkArrecadacaoCadastroEconomicoFaturamento(\Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento $fkArrecadacaoCadastroEconomicoFaturamento)
    {
        $this->inscricaoEconomica = $fkArrecadacaoCadastroEconomicoFaturamento->getInscricaoEconomica();
        $this->timestamp = $fkArrecadacaoCadastroEconomicoFaturamento->getTimestamp();
        $this->fkArrecadacaoCadastroEconomicoFaturamento = $fkArrecadacaoCadastroEconomicoFaturamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCadastroEconomicoFaturamento
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento
     */
    public function getFkArrecadacaoCadastroEconomicoFaturamento()
    {
        return $this->fkArrecadacaoCadastroEconomicoFaturamento;
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
     * Set ArrecadacaoServicoSemRetencao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ServicoSemRetencao $fkArrecadacaoServicoSemRetencao
     * @return FaturamentoServico
     */
    public function setFkArrecadacaoServicoSemRetencao(\Urbem\CoreBundle\Entity\Arrecadacao\ServicoSemRetencao $fkArrecadacaoServicoSemRetencao)
    {
        $fkArrecadacaoServicoSemRetencao->setFkArrecadacaoFaturamentoServico($this);
        $this->fkArrecadacaoServicoSemRetencao = $fkArrecadacaoServicoSemRetencao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoServicoSemRetencao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ServicoSemRetencao
     */
    public function getFkArrecadacaoServicoSemRetencao()
    {
        return $this->fkArrecadacaoServicoSemRetencao;
    }
}
