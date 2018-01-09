<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * TipoFiscalizacao
 */
class TipoFiscalizacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Documento
     */
    private $fkFiscalizacaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao
     */
    private $fkFiscalizacaoFiscalFiscalizacoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    private $fkFiscalizacaoInfracoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoFiscalFiscalizacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoFiscalizacao
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoFiscalizacao
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
     * Add FiscalizacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Documento $fkFiscalizacaoDocumento
     * @return TipoFiscalizacao
     */
    public function addFkFiscalizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\Documento $fkFiscalizacaoDocumento)
    {
        if (false === $this->fkFiscalizacaoDocumentos->contains($fkFiscalizacaoDocumento)) {
            $fkFiscalizacaoDocumento->setFkFiscalizacaoTipoFiscalizacao($this);
            $this->fkFiscalizacaoDocumentos->add($fkFiscalizacaoDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Documento $fkFiscalizacaoDocumento
     */
    public function removeFkFiscalizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\Documento $fkFiscalizacaoDocumento)
    {
        $this->fkFiscalizacaoDocumentos->removeElement($fkFiscalizacaoDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Documento
     */
    public function getFkFiscalizacaoDocumentos()
    {
        return $this->fkFiscalizacaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoFiscalFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao $fkFiscalizacaoFiscalFiscalizacao
     * @return TipoFiscalizacao
     */
    public function addFkFiscalizacaoFiscalFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao $fkFiscalizacaoFiscalFiscalizacao)
    {
        if (false === $this->fkFiscalizacaoFiscalFiscalizacoes->contains($fkFiscalizacaoFiscalFiscalizacao)) {
            $fkFiscalizacaoFiscalFiscalizacao->setFkFiscalizacaoTipoFiscalizacao($this);
            $this->fkFiscalizacaoFiscalFiscalizacoes->add($fkFiscalizacaoFiscalFiscalizacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoFiscalFiscalizacao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao $fkFiscalizacaoFiscalFiscalizacao
     */
    public function removeFkFiscalizacaoFiscalFiscalizacoes(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao $fkFiscalizacaoFiscalFiscalizacao)
    {
        $this->fkFiscalizacaoFiscalFiscalizacoes->removeElement($fkFiscalizacaoFiscalFiscalizacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoFiscalFiscalizacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalFiscalizacao
     */
    public function getFkFiscalizacaoFiscalFiscalizacoes()
    {
        return $this->fkFiscalizacaoFiscalFiscalizacoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return TipoFiscalizacao
     */
    public function addFkFiscalizacaoProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscais->contains($fkFiscalizacaoProcessoFiscal)) {
            $fkFiscalizacaoProcessoFiscal->setFkFiscalizacaoTipoFiscalizacao($this);
            $this->fkFiscalizacaoProcessoFiscais->add($fkFiscalizacaoProcessoFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     */
    public function removeFkFiscalizacaoProcessoFiscais(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->fkFiscalizacaoProcessoFiscais->removeElement($fkFiscalizacaoProcessoFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscais()
    {
        return $this->fkFiscalizacaoProcessoFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao
     * @return TipoFiscalizacao
     */
    public function addFkFiscalizacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao)
    {
        if (false === $this->fkFiscalizacaoInfracoes->contains($fkFiscalizacaoInfracao)) {
            $fkFiscalizacaoInfracao->setFkFiscalizacaoTipoFiscalizacao($this);
            $this->fkFiscalizacaoInfracoes->add($fkFiscalizacaoInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao
     */
    public function removeFkFiscalizacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao)
    {
        $this->fkFiscalizacaoInfracoes->removeElement($fkFiscalizacaoInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    public function getFkFiscalizacaoInfracoes()
    {
        return $this->fkFiscalizacaoInfracoes;
    }
}
