<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Modalidade
 */
class Modalidade
{
    const MODALIDADE_CHAMADA_PUBLICA_ZERO = [8,9,10];

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDiretas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaModalidade
     */
    private $fkComprasMapaModalidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos
     */
    private $fkLicitacaoModalidadeDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    private $fkLicitacaoLicitacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp
     */
    private $fkTcemgArquivoEmps;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkComprasCompraDiretas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasMapaModalidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoModalidadeDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkLicitacaoLicitacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkTcemgArquivoEmps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Modalidade
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
     * Set descricao
     *
     * @param string $descricao
     * @return Modalidade
     */
    public function setDescricao($descricao = null)
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
     * Add ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return Modalidade
     */
    public function addFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        if (false === $this->fkComprasCompraDiretas->contains($fkComprasCompraDireta)) {
            $fkComprasCompraDireta->setFkComprasModalidade($this);
            $this->fkComprasCompraDiretas->add($fkComprasCompraDireta);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     */
    public function removeFkComprasCompraDiretas(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        $this->fkComprasCompraDiretas->removeElement($fkComprasCompraDireta);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasCompraDiretas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    public function getFkComprasCompraDiretas()
    {
        return $this->fkComprasCompraDiretas;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasMapaModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaModalidade $fkComprasMapaModalidade
     * @return Modalidade
     */
    public function addFkComprasMapaModalidades(\Urbem\CoreBundle\Entity\Compras\MapaModalidade $fkComprasMapaModalidade)
    {
        if (false === $this->fkComprasMapaModalidades->contains($fkComprasMapaModalidade)) {
            $fkComprasMapaModalidade->setFkComprasModalidade($this);
            $this->fkComprasMapaModalidades->add($fkComprasMapaModalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasMapaModalidade
     *
     * @param \Urbem\CoreBundle\Entity\Compras\MapaModalidade $fkComprasMapaModalidade
     */
    public function removeFkComprasMapaModalidades(\Urbem\CoreBundle\Entity\Compras\MapaModalidade $fkComprasMapaModalidade)
    {
        $this->fkComprasMapaModalidades->removeElement($fkComprasMapaModalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasMapaModalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\MapaModalidade
     */
    public function getFkComprasMapaModalidades()
    {
        return $this->fkComprasMapaModalidades;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho
     * @return Modalidade
     */
    public function addFkFolhapagamentoConfiguracaoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos->contains($fkFolhapagamentoConfiguracaoAutorizacaoEmpenho)) {
            $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho->setFkComprasModalidade($this);
            $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos->add($fkFolhapagamentoConfiguracaoAutorizacaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoAutorizacaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho
     */
    public function removeFkFolhapagamentoConfiguracaoAutorizacaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho $fkFolhapagamentoConfiguracaoAutorizacaoEmpenho)
    {
        $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos->removeElement($fkFolhapagamentoConfiguracaoAutorizacaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAutorizacaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoAutorizacaoEmpenhos()
    {
        return $this->fkFolhapagamentoConfiguracaoAutorizacaoEmpenhos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoModalidadeDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos $fkLicitacaoModalidadeDocumentos
     * @return Modalidade
     */
    public function addFkLicitacaoModalidadeDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos $fkLicitacaoModalidadeDocumentos)
    {
        if (false === $this->fkLicitacaoModalidadeDocumentos->contains($fkLicitacaoModalidadeDocumentos)) {
            $fkLicitacaoModalidadeDocumentos->setFkComprasModalidade($this);
            $this->fkLicitacaoModalidadeDocumentos->add($fkLicitacaoModalidadeDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoModalidadeDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos $fkLicitacaoModalidadeDocumentos
     */
    public function removeFkLicitacaoModalidadeDocumentos(\Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos $fkLicitacaoModalidadeDocumentos)
    {
        $this->fkLicitacaoModalidadeDocumentos->removeElement($fkLicitacaoModalidadeDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoModalidadeDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\ModalidadeDocumentos
     */
    public function getFkLicitacaoModalidadeDocumentos()
    {
        return $this->fkLicitacaoModalidadeDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     * @return Modalidade
     */
    public function addFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        if (false === $this->fkLicitacaoLicitacoes->contains($fkLicitacaoLicitacao)) {
            $fkLicitacaoLicitacao->setFkComprasModalidade($this);
            $this->fkLicitacaoLicitacoes->add($fkLicitacaoLicitacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove LicitacaoLicitacao
     *
     * @param \Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao
     */
    public function removeFkLicitacaoLicitacoes(\Urbem\CoreBundle\Entity\Licitacao\Licitacao $fkLicitacaoLicitacao)
    {
        $this->fkLicitacaoLicitacoes->removeElement($fkLicitacaoLicitacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkLicitacaoLicitacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Licitacao\Licitacao
     */
    public function getFkLicitacaoLicitacoes()
    {
        return $this->fkLicitacaoLicitacoes;
    }

    /**
     * OneToMany (owning side)
     * Add TcemgArquivoEmp
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp $fkTcemgArquivoEmp
     * @return Modalidade
     */
    public function addFkTcemgArquivoEmps(\Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp $fkTcemgArquivoEmp)
    {
        if (false === $this->fkTcemgArquivoEmps->contains($fkTcemgArquivoEmp)) {
            $fkTcemgArquivoEmp->setFkComprasModalidade($this);
            $this->fkTcemgArquivoEmps->add($fkTcemgArquivoEmp);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcemgArquivoEmp
     *
     * @param \Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp $fkTcemgArquivoEmp
     */
    public function removeFkTcemgArquivoEmps(\Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp $fkTcemgArquivoEmp)
    {
        $this->fkTcemgArquivoEmps->removeElement($fkTcemgArquivoEmp);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcemgArquivoEmps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcemg\ArquivoEmp
     */
    public function getFkTcemgArquivoEmps()
    {
        return $this->fkTcemgArquivoEmps;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codModalidade, $this->descricao);
    }
}
