<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Acao
 */
class Acao
{
    const PARAMETER_ROUTE_DEFAULT = 'route_new_urbem';

    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * @var integer
     */
    private $codFuncionalidade;

    /**
     * @var string
     */
    private $nomArquivo;

    /**
     * @var string
     */
    private $parametro;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * @var string
     */
    private $complementoAcao;

    /**
     * @var string
     */
    private $nomAcao;

    /**
     * @var boolean
     */
    private $ativo = true;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativaAcao
     */
    private $fkContabilidadeNotaExplicativaAcao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Auditoria
     */
    private $fkAdministracaoAuditorias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\RelatorioAcao
     */
    private $fkAdministracaoRelatorioAcoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne
     */
    private $fkArrecadacaoAcaoModeloCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao
     */
    private $fkProtocoloAssuntoAcoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\NotaExplicativa
     */
    private $fkStnNotaExplicativas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Permissao
     */
    private $fkAdministracaoPermissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento
     */
    private $fkAdministracaoModeloArquivosDocumentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcionalidade
     */
    private $fkAdministracaoFuncionalidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoAuditorias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoRelatorioAcoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAcaoModeloCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkProtocoloAssuntoAcoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkStnNotaExplicativas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkAdministracaoModeloArquivosDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return Acao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set codFuncionalidade
     *
     * @param integer $codFuncionalidade
     * @return Acao
     */
    public function setCodFuncionalidade($codFuncionalidade)
    {
        $this->codFuncionalidade = $codFuncionalidade;
        return $this;
    }

    /**
     * Get codFuncionalidade
     *
     * @return integer
     */
    public function getCodFuncionalidade()
    {
        return $this->codFuncionalidade;
    }

    /**
     * Set nomArquivo
     *
     * @param string $nomArquivo
     * @return Acao
     */
    public function setNomArquivo($nomArquivo)
    {
        $this->nomArquivo = $nomArquivo;
        return $this;
    }

    /**
     * Get nomArquivo
     *
     * @return string
     */
    public function getNomArquivo()
    {
        return $this->nomArquivo;
    }

    /**
     * Set parametro
     *
     * @param string $parametro
     * @return Acao
     */
    public function setParametro($parametro)
    {
        $this->parametro = $parametro;
        return $this;
    }

    /**
     * Get parametro
     *
     * @return string
     */
    public function getParametro()
    {
        return $this->parametro;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return Acao
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * Set complementoAcao
     *
     * @param string $complementoAcao
     * @return Acao
     */
    public function setComplementoAcao($complementoAcao = null)
    {
        $this->complementoAcao = $complementoAcao;
        return $this;
    }

    /**
     * Get complementoAcao
     *
     * @return string
     */
    public function getComplementoAcao()
    {
        return $this->complementoAcao;
    }

    /**
     * Set nomAcao
     *
     * @param string $nomAcao
     * @return Acao
     */
    public function setNomAcao($nomAcao)
    {
        $this->nomAcao = $nomAcao;
        return $this;
    }

    /**
     * Get nomAcao
     *
     * @return string
     */
    public function getNomAcao()
    {
        return $this->nomAcao;
    }

    /**
     * Set ativo
     *
     * @param boolean $ativo
     * @return Acao
     */
    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
        return $this;
    }

    /**
     * Get ativo
     *
     * @return boolean
     */
    public function getAtivo()
    {
        return $this->ativo;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Auditoria $fkAdministracaoAuditoria
     * @return Acao
     */
    public function addFkAdministracaoAuditorias(\Urbem\CoreBundle\Entity\Administracao\Auditoria $fkAdministracaoAuditoria)
    {
        if (false === $this->fkAdministracaoAuditorias->contains($fkAdministracaoAuditoria)) {
            $fkAdministracaoAuditoria->setFkAdministracaoAcao($this);
            $this->fkAdministracaoAuditorias->add($fkAdministracaoAuditoria);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoAuditoria
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Auditoria $fkAdministracaoAuditoria
     */
    public function removeFkAdministracaoAuditorias(\Urbem\CoreBundle\Entity\Administracao\Auditoria $fkAdministracaoAuditoria)
    {
        $this->fkAdministracaoAuditorias->removeElement($fkAdministracaoAuditoria);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoAuditorias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Auditoria
     */
    public function getFkAdministracaoAuditorias()
    {
        return $this->fkAdministracaoAuditorias;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoRelatorioAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\RelatorioAcao $fkAdministracaoRelatorioAcao
     * @return Acao
     */
    public function addFkAdministracaoRelatorioAcoes(\Urbem\CoreBundle\Entity\Administracao\RelatorioAcao $fkAdministracaoRelatorioAcao)
    {
        if (false === $this->fkAdministracaoRelatorioAcoes->contains($fkAdministracaoRelatorioAcao)) {
            $fkAdministracaoRelatorioAcao->setFkAdministracaoAcao($this);
            $this->fkAdministracaoRelatorioAcoes->add($fkAdministracaoRelatorioAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoRelatorioAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\RelatorioAcao $fkAdministracaoRelatorioAcao
     */
    public function removeFkAdministracaoRelatorioAcoes(\Urbem\CoreBundle\Entity\Administracao\RelatorioAcao $fkAdministracaoRelatorioAcao)
    {
        $this->fkAdministracaoRelatorioAcoes->removeElement($fkAdministracaoRelatorioAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoRelatorioAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\RelatorioAcao
     */
    public function getFkAdministracaoRelatorioAcoes()
    {
        return $this->fkAdministracaoRelatorioAcoes;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAcaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne $fkArrecadacaoAcaoModeloCarne
     * @return Acao
     */
    public function addFkArrecadacaoAcaoModeloCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne $fkArrecadacaoAcaoModeloCarne)
    {
        if (false === $this->fkArrecadacaoAcaoModeloCarnes->contains($fkArrecadacaoAcaoModeloCarne)) {
            $fkArrecadacaoAcaoModeloCarne->setFkAdministracaoAcao($this);
            $this->fkArrecadacaoAcaoModeloCarnes->add($fkArrecadacaoAcaoModeloCarne);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAcaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne $fkArrecadacaoAcaoModeloCarne
     */
    public function removeFkArrecadacaoAcaoModeloCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne $fkArrecadacaoAcaoModeloCarne)
    {
        $this->fkArrecadacaoAcaoModeloCarnes->removeElement($fkArrecadacaoAcaoModeloCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAcaoModeloCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AcaoModeloCarne
     */
    public function getFkArrecadacaoAcaoModeloCarnes()
    {
        return $this->fkArrecadacaoAcaoModeloCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add ProtocoloAssuntoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao $fkProtocoloAssuntoAcao
     * @return Acao
     */
    public function addFkProtocoloAssuntoAcoes(\Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao $fkProtocoloAssuntoAcao)
    {
        if (false === $this->fkProtocoloAssuntoAcoes->contains($fkProtocoloAssuntoAcao)) {
            $fkProtocoloAssuntoAcao->setFkAdministracaoAcao($this);
            $this->fkProtocoloAssuntoAcoes->add($fkProtocoloAssuntoAcao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ProtocoloAssuntoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao $fkProtocoloAssuntoAcao
     */
    public function removeFkProtocoloAssuntoAcoes(\Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao $fkProtocoloAssuntoAcao)
    {
        $this->fkProtocoloAssuntoAcoes->removeElement($fkProtocoloAssuntoAcao);
    }

    /**
     * OneToMany (owning side)
     * Get fkProtocoloAssuntoAcoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao
     */
    public function getFkProtocoloAssuntoAcoes()
    {
        return $this->fkProtocoloAssuntoAcoes;
    }

    /**
     * OneToMany (owning side)
     * Add StnNotaExplicativa
     *
     * @param \Urbem\CoreBundle\Entity\Stn\NotaExplicativa $fkStnNotaExplicativa
     * @return Acao
     */
    public function addFkStnNotaExplicativas(\Urbem\CoreBundle\Entity\Stn\NotaExplicativa $fkStnNotaExplicativa)
    {
        if (false === $this->fkStnNotaExplicativas->contains($fkStnNotaExplicativa)) {
            $fkStnNotaExplicativa->setFkAdministracaoAcao($this);
            $this->fkStnNotaExplicativas->add($fkStnNotaExplicativa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnNotaExplicativa
     *
     * @param \Urbem\CoreBundle\Entity\Stn\NotaExplicativa $fkStnNotaExplicativa
     */
    public function removeFkStnNotaExplicativas(\Urbem\CoreBundle\Entity\Stn\NotaExplicativa $fkStnNotaExplicativa)
    {
        $this->fkStnNotaExplicativas->removeElement($fkStnNotaExplicativa);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnNotaExplicativas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\NotaExplicativa
     */
    public function getFkStnNotaExplicativas()
    {
        return $this->fkStnNotaExplicativas;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Permissao $fkAdministracaoPermissao
     * @return Acao
     */
    public function addFkAdministracaoPermissoes(\Urbem\CoreBundle\Entity\Administracao\Permissao $fkAdministracaoPermissao)
    {
        if (false === $this->fkAdministracaoPermissoes->contains($fkAdministracaoPermissao)) {
            $fkAdministracaoPermissao->setFkAdministracaoAcao($this);
            $this->fkAdministracaoPermissoes->add($fkAdministracaoPermissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Permissao $fkAdministracaoPermissao
     */
    public function removeFkAdministracaoPermissoes(\Urbem\CoreBundle\Entity\Administracao\Permissao $fkAdministracaoPermissao)
    {
        $this->fkAdministracaoPermissoes->removeElement($fkAdministracaoPermissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Permissao
     */
    public function getFkAdministracaoPermissoes()
    {
        return $this->fkAdministracaoPermissoes;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoModeloArquivosDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento
     * @return Acao
     */
    public function addFkAdministracaoModeloArquivosDocumentos(\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento)
    {
        if (false === $this->fkAdministracaoModeloArquivosDocumentos->contains($fkAdministracaoModeloArquivosDocumento)) {
            $fkAdministracaoModeloArquivosDocumento->setFkAdministracaoAcao($this);
            $this->fkAdministracaoModeloArquivosDocumentos->add($fkAdministracaoModeloArquivosDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoModeloArquivosDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento
     */
    public function removeFkAdministracaoModeloArquivosDocumentos(\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento $fkAdministracaoModeloArquivosDocumento)
    {
        $this->fkAdministracaoModeloArquivosDocumentos->removeElement($fkAdministracaoModeloArquivosDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoModeloArquivosDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento
     */
    public function getFkAdministracaoModeloArquivosDocumentos()
    {
        return $this->fkAdministracaoModeloArquivosDocumentos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncionalidade
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcionalidade $fkAdministracaoFuncionalidade
     * @return Acao
     */
    public function setFkAdministracaoFuncionalidade(\Urbem\CoreBundle\Entity\Administracao\Funcionalidade $fkAdministracaoFuncionalidade)
    {
        $this->codFuncionalidade = $fkAdministracaoFuncionalidade->getCodFuncionalidade();
        $this->fkAdministracaoFuncionalidade = $fkAdministracaoFuncionalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncionalidade
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcionalidade
     */
    public function getFkAdministracaoFuncionalidade()
    {
        return $this->fkAdministracaoFuncionalidade;
    }

    /**
     * OneToOne (inverse side)
     * Set ContabilidadeNotaExplicativaAcao
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativaAcao $fkContabilidadeNotaExplicativaAcao
     * @return Acao
     */
    public function setFkContabilidadeNotaExplicativaAcao(\Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativaAcao $fkContabilidadeNotaExplicativaAcao)
    {
        $fkContabilidadeNotaExplicativaAcao->setFkAdministracaoAcao($this);
        $this->fkContabilidadeNotaExplicativaAcao = $fkContabilidadeNotaExplicativaAcao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkContabilidadeNotaExplicativaAcao
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativaAcao
     */
    public function getFkContabilidadeNotaExplicativaAcao()
    {
        return $this->fkContabilidadeNotaExplicativaAcao;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->nomAcao;
    }
}
