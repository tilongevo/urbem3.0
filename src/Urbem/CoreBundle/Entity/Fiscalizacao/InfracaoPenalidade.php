<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * InfracaoPenalidade
 */
class InfracaoPenalidade
{
    /**
     * PK
     * @var integer
     */
    private $codInfracao;

    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao
     */
    private $fkFiscalizacaoNotificacaoInfracoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao
     */
    private $fkFiscalizacaoAutoInfracoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    private $fkFiscalizacaoInfracao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    private $fkFiscalizacaoPenalidade;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoNotificacaoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoAutoInfracoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return InfracaoPenalidade
     */
    public function setCodInfracao($codInfracao)
    {
        $this->codInfracao = $codInfracao;
        return $this;
    }

    /**
     * Get codInfracao
     *
     * @return integer
     */
    public function getCodInfracao()
    {
        return $this->codInfracao;
    }

    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return InfracaoPenalidade
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return InfracaoPenalidade
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoNotificacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao
     * @return InfracaoPenalidade
     */
    public function addFkFiscalizacaoNotificacaoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoInfracao $fkFiscalizacaoNotificacaoInfracao)
    {
        if (false === $this->fkFiscalizacaoNotificacaoInfracoes->contains($fkFiscalizacaoNotificacaoInfracao)) {
            $fkFiscalizacaoNotificacaoInfracao->setFkFiscalizacaoInfracaoPenalidade($this);
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
     * OneToMany (owning side)
     * Add FiscalizacaoAutoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao
     * @return InfracaoPenalidade
     */
    public function addFkFiscalizacaoAutoInfracoes(\Urbem\CoreBundle\Entity\Fiscalizacao\AutoInfracao $fkFiscalizacaoAutoInfracao)
    {
        if (false === $this->fkFiscalizacaoAutoInfracoes->contains($fkFiscalizacaoAutoInfracao)) {
            $fkFiscalizacaoAutoInfracao->setFkFiscalizacaoInfracaoPenalidade($this);
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
     * Set fkFiscalizacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao
     * @return InfracaoPenalidade
     */
    public function setFkFiscalizacaoInfracao(\Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao)
    {
        $this->codInfracao = $fkFiscalizacaoInfracao->getCodInfracao();
        $this->fkFiscalizacaoInfracao = $fkFiscalizacaoInfracao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoInfracao
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    public function getFkFiscalizacaoInfracao()
    {
        return $this->fkFiscalizacaoInfracao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     * @return InfracaoPenalidade
     */
    public function setFkFiscalizacaoPenalidade(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        $this->codPenalidade = $fkFiscalizacaoPenalidade->getCodPenalidade();
        $this->fkFiscalizacaoPenalidade = $fkFiscalizacaoPenalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    public function getFkFiscalizacaoPenalidade()
    {
        return $this->fkFiscalizacaoPenalidade;
    }
}
