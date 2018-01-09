<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * NotificacaoFiscalizacao
 */
class NotificacaoFiscalizacao
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
     * @var integer
     */
    private $numNotificacao;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscal
     */
    private $fkFiscalizacaoProcessoFiscal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao
     */
    private $fkFiscalizacaoNotificacaoInfracoes;

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
        $this->fkFiscalizacaoNotificacaoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return NotificacaoFiscalizacao
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
     * @return NotificacaoFiscalizacao
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
     * @return NotificacaoFiscalizacao
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
     * @return NotificacaoFiscalizacao
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
     * @return NotificacaoFiscalizacao
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
     * @return NotificacaoFiscalizacao
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
     * @return NotificacaoFiscalizacao
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
     * Set numNotificacao
     *
     * @param integer $numNotificacao
     * @return NotificacaoFiscalizacao
     */
    public function setNumNotificacao($numNotificacao)
    {
        $this->numNotificacao = $numNotificacao;
        return $this;
    }

    /**
     * Get numNotificacao
     *
     * @return integer
     */
    public function getNumNotificacao()
    {
        return $this->numNotificacao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotificacaoFiscalizacao
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
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao
     * @return NotificacaoFiscalizacao
     */
    public function addFkFiscalizacaoNotificacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao)
    {
        if (false === $this->fkFiscalizacaoNotificacaoInfracoes->contains($fkFiscalizacaoNotificacaoInfracao)) {
            $fkFiscalizacaoNotificacaoInfracao->setFkFiscalizacaoNotificacaoFiscalizacao($this);
            $this->fkFiscalizacaoNotificacaoInfracoes->add($fkFiscalizacaoNotificacaoInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao
     */
    public function removeFkFiscalizacaoNotificacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao)
    {
        $this->fkFiscalizacaoNotificacaoInfracoes->removeElement($fkFiscalizacaoNotificacaoInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao
     */
    public function getFkFiscalizacaoNotificacaoInfracoes()
    {
        return $this->fkFiscalizacaoNotificacaoInfracoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     * @return NotificacaoFiscalizacao
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
     * @return NotificacaoFiscalizacao
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
     * @return NotificacaoFiscalizacao
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
