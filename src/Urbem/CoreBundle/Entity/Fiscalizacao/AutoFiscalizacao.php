<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * AutoFiscalizacao
 */
class AutoFiscalizacao
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var integer
     */
    private $codAutoFiscalizacao;

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
    private $dtNotificacao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    private $fkFiscalizacaoAutoInfracoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal
     */
    private $fkFiscalizacaoFiscalProcessoFiscal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscal;

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
        $this->fkFiscalizacaoAutoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return AutoFiscalizacao
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
     * Set codAutoFiscalizacao
     *
     * @param integer $codAutoFiscalizacao
     * @return AutoFiscalizacao
     */
    public function setCodAutoFiscalizacao($codAutoFiscalizacao)
    {
        $this->codAutoFiscalizacao = $codAutoFiscalizacao;
        return $this;
    }

    /**
     * Get codAutoFiscalizacao
     *
     * @return integer
     */
    public function getCodAutoFiscalizacao()
    {
        return $this->codAutoFiscalizacao;
    }

    /**
     * Set codFiscal
     *
     * @param integer $codFiscal
     * @return AutoFiscalizacao
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
     * @return AutoFiscalizacao
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
     * @return AutoFiscalizacao
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
     * Set dtNotificacao
     *
     * @param \DateTime $dtNotificacao
     * @return AutoFiscalizacao
     */
    public function setDtNotificacao(\DateTime $dtNotificacao)
    {
        $this->dtNotificacao = $dtNotificacao;
        return $this;
    }

    /**
     * Get dtNotificacao
     *
     * @return \DateTime
     */
    public function getDtNotificacao()
    {
        return $this->dtNotificacao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return AutoFiscalizacao
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
     * @return AutoFiscalizacao
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
     * Add FiscalizacaoAutoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao
     * @return AutoFiscalizacao
     */
    public function addFkFiscalizacaoAutoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao)
    {
        if (false === $this->fkFiscalizacaoAutoInfracoes->contains($fkFiscalizacaoAutoInfracao)) {
            $fkFiscalizacaoAutoInfracao->setFkFiscalizacaoAutoFiscalizacao($this);
            $this->fkFiscalizacaoAutoInfracoes->add($fkFiscalizacaoAutoInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoAutoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao
     */
    public function removeFkFiscalizacaoAutoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao)
    {
        $this->fkFiscalizacaoAutoInfracoes->removeElement($fkFiscalizacaoAutoInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoAutoInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    public function getFkFiscalizacaoAutoInfracoes()
    {
        return $this->fkFiscalizacaoAutoInfracoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     * @return AutoFiscalizacao
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
     * Set fkFiscalizacaoProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal
     * @return AutoFiscalizacao
     */
    public function setFkFiscalizacaoProcessoFiscal(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal $fkFiscalizacaoProcessoFiscal)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoFiscal->getCodProcesso();
        $this->fkFiscalizacaoProcessoFiscal = $fkFiscalizacaoProcessoFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoProcessoFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    public function getFkFiscalizacaoProcessoFiscal()
    {
        return $this->fkFiscalizacaoProcessoFiscal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return AutoFiscalizacao
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
}
