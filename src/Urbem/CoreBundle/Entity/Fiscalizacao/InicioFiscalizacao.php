<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * InicioFiscalizacao
 */
class InicioFiscalizacao
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * @var integer
     */
    private $codFiscal;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var \DateTime
     */
    private $dtInicio;

    /**
     * @var string
     */
    private $localEntrega;

    /**
     * @var \DateTime
     */
    private $prazoEntrega;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos
     */
    private $fkFiscalizacaoInicioFiscalizacaoDocumentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProrrogacaoEntrega
     */
    private $fkFiscalizacaoProrrogacaoEntregas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    private $fkFiscalizacaoFiscalProcessoFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoInicioFiscalizacaoDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProrrogacaoEntregas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return InicioFiscalizacao
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
     * Set codFiscal
     *
     * @param integer $codFiscal
     * @return InicioFiscalizacao
     */
    public function setCodFiscal($codFiscal)
    {
        $this->codFiscal = $codFiscal;
        return $this;
    }

    /**
     * Get codFiscal
     *
     * @return integer
     */
    public function getCodFiscal()
    {
        return $this->codFiscal;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return InicioFiscalizacao
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return InicioFiscalizacao
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set dtInicio
     *
     * @param \DateTime $dtInicio
     * @return InicioFiscalizacao
     */
    public function setDtInicio(\DateTime $dtInicio)
    {
        $this->dtInicio = $dtInicio;
        return $this;
    }

    /**
     * Get dtInicio
     *
     * @return \DateTime
     */
    public function getDtInicio()
    {
        return $this->dtInicio;
    }

    /**
     * Set localEntrega
     *
     * @param string $localEntrega
     * @return InicioFiscalizacao
     */
    public function setLocalEntrega($localEntrega)
    {
        $this->localEntrega = $localEntrega;
        return $this;
    }

    /**
     * Get localEntrega
     *
     * @return string
     */
    public function getLocalEntrega()
    {
        return $this->localEntrega;
    }

    /**
     * Set prazoEntrega
     *
     * @param \DateTime $prazoEntrega
     * @return InicioFiscalizacao
     */
    public function setPrazoEntrega(\DateTime $prazoEntrega)
    {
        $this->prazoEntrega = $prazoEntrega;
        return $this;
    }

    /**
     * Get prazoEntrega
     *
     * @return \DateTime
     */
    public function getPrazoEntrega()
    {
        return $this->prazoEntrega;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return InicioFiscalizacao
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return InicioFiscalizacao
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInicioFiscalizacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos
     * @return InicioFiscalizacao
     */
    public function addFkFiscalizacaoInicioFiscalizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos)
    {
        if (false === $this->fkFiscalizacaoInicioFiscalizacaoDocumentos->contains($fkFiscalizacaoInicioFiscalizacaoDocumentos)) {
            $fkFiscalizacaoInicioFiscalizacaoDocumentos->setFkFiscalizacaoInicioFiscalizacao($this);
            $this->fkFiscalizacaoInicioFiscalizacaoDocumentos->add($fkFiscalizacaoInicioFiscalizacaoDocumentos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInicioFiscalizacaoDocumentos
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos
     */
    public function removeFkFiscalizacaoInicioFiscalizacaoDocumentos(\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos $fkFiscalizacaoInicioFiscalizacaoDocumentos)
    {
        $this->fkFiscalizacaoInicioFiscalizacaoDocumentos->removeElement($fkFiscalizacaoInicioFiscalizacaoDocumentos);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInicioFiscalizacaoDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InicioFiscalizacaoDocumentos
     */
    public function getFkFiscalizacaoInicioFiscalizacaoDocumentos()
    {
        return $this->fkFiscalizacaoInicioFiscalizacaoDocumentos;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProrrogacaoEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProrrogacaoEntrega $fkFiscalizacaoProrrogacaoEntrega
     * @return InicioFiscalizacao
     */
    public function addFkFiscalizacaoProrrogacaoEntregas(\Urbem\CoreBundle\Entity\Fiscalizacao\ProrrogacaoEntrega $fkFiscalizacaoProrrogacaoEntrega)
    {
        if (false === $this->fkFiscalizacaoProrrogacaoEntregas->contains($fkFiscalizacaoProrrogacaoEntrega)) {
            $fkFiscalizacaoProrrogacaoEntrega->setFkFiscalizacaoInicioFiscalizacao($this);
            $this->fkFiscalizacaoProrrogacaoEntregas->add($fkFiscalizacaoProrrogacaoEntrega);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProrrogacaoEntrega
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProrrogacaoEntrega $fkFiscalizacaoProrrogacaoEntrega
     */
    public function removeFkFiscalizacaoProrrogacaoEntregas(\Urbem\CoreBundle\Entity\Fiscalizacao\ProrrogacaoEntrega $fkFiscalizacaoProrrogacaoEntrega)
    {
        $this->fkFiscalizacaoProrrogacaoEntregas->removeElement($fkFiscalizacaoProrrogacaoEntrega);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProrrogacaoEntregas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProrrogacaoEntrega
     */
    public function getFkFiscalizacaoProrrogacaoEntregas()
    {
        return $this->fkFiscalizacaoProrrogacaoEntregas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     * @return InicioFiscalizacao
     */
    public function setFkFiscalizacaoFiscalProcessoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal)
    {
        $this->codProcesso = $fkFiscalizacaoFiscalProcessoFiscal->getCodProcesso();
        $this->codFiscal = $fkFiscalizacaoFiscalProcessoFiscal->getCodFiscal();
        $this->fkFiscalizacaoFiscalProcessoFiscal = $fkFiscalizacaoFiscalProcessoFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoFiscalProcessoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    public function getFkFiscalizacaoFiscalProcessoFiscal()
    {
        return $this->fkFiscalizacaoFiscalProcessoFiscal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return InicioFiscalizacao
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return InicioFiscalizacao
     */
    public function setFkFiscalizacaoProcessoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoFiscal->getCodProcesso();
        $this->fkFiscalizacaoProcessoFiscal = $fkFiscalizacaoProcessoFiscal;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoProcessoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscal()
    {
        return $this->fkFiscalizacaoProcessoFiscal;
    }
}
