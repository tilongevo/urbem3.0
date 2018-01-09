<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * NotificacaoTermo
 */
class NotificacaoTermo
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
    private $numNotificacao;

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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao
     */
    private $fkFiscalizacaoNotificacaoTermoInfracoes;

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
        $this->fkFiscalizacaoNotificacaoTermoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return NotificacaoTermo
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
     * Set numNotificacao
     *
     * @param integer $numNotificacao
     * @return NotificacaoTermo
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
     * Set codFiscal
     *
     * @param integer $codFiscal
     * @return NotificacaoTermo
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
     * @return NotificacaoTermo
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
     * @return NotificacaoTermo
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
     * @return NotificacaoTermo
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
     * @return NotificacaoTermo
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
     * @return NotificacaoTermo
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
     * Add FiscalizacaoNotificacaoTermoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao $fkFiscalizacaoNotificacaoTermoInfracao
     * @return NotificacaoTermo
     */
    public function addFkFiscalizacaoNotificacaoTermoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao $fkFiscalizacaoNotificacaoTermoInfracao)
    {
        if (false === $this->fkFiscalizacaoNotificacaoTermoInfracoes->contains($fkFiscalizacaoNotificacaoTermoInfracao)) {
            $fkFiscalizacaoNotificacaoTermoInfracao->setFkFiscalizacaoNotificacaoTermo($this);
            $this->fkFiscalizacaoNotificacaoTermoInfracoes->add($fkFiscalizacaoNotificacaoTermoInfracao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoNotificacaoTermoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao $fkFiscalizacaoNotificacaoTermoInfracao
     */
    public function removeFkFiscalizacaoNotificacaoTermoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao $fkFiscalizacaoNotificacaoTermoInfracao)
    {
        $this->fkFiscalizacaoNotificacaoTermoInfracoes->removeElement($fkFiscalizacaoNotificacaoTermoInfracao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoNotificacaoTermoInfracoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermoInfracao
     */
    public function getFkFiscalizacaoNotificacaoTermoInfracoes()
    {
        return $this->fkFiscalizacaoNotificacaoTermoInfracoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoFiscalProcessoFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\FiscalProcessoFiscal $fkFiscalizacaoFiscalProcessoFiscal
     * @return NotificacaoTermo
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
     * @return NotificacaoTermo
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
     * @return NotificacaoTermo
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
     * PrePersist
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function generatePkSequence(\Doctrine\Common\Persistence\Event\LifecycleEventArgs $args)
    {
        $this->numNotificacao = (new \Doctrine\ORM\Id\SequenceGenerator('fiscalizacao.notificacao_termo_num_notificacao_seq', 1))->generate($args->getObjectManager(), $this);
    }
}
