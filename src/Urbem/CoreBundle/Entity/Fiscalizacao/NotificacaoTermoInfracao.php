<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * NotificacaoTermoInfracao
 */
class NotificacaoTermoInfracao
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
     * PK
     * @var integer
     */
    private $codInfracao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo
     */
    private $fkFiscalizacaoNotificacaoTermo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao
     */
    private $fkFiscalizacaoInfracao;


    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return NotificacaoTermoInfracao
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
     * @return NotificacaoTermoInfracao
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
     * Set codInfracao
     *
     * @param integer $codInfracao
     * @return NotificacaoTermoInfracao
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
     * Set observacao
     *
     * @param string $observacao
     * @return NotificacaoTermoInfracao
     */
    public function setObservacao($observacao = null)
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
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoNotificacaoTermo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo
     * @return NotificacaoTermoInfracao
     */
    public function setFkFiscalizacaoNotificacaoTermo(\Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo $fkFiscalizacaoNotificacaoTermo)
    {
        $this->codProcesso = $fkFiscalizacaoNotificacaoTermo->getCodProcesso();
        $this->numNotificacao = $fkFiscalizacaoNotificacaoTermo->getNumNotificacao();
        $this->fkFiscalizacaoNotificacaoTermo = $fkFiscalizacaoNotificacaoTermo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoNotificacaoTermo
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\NotificacaoTermo
     */
    public function getFkFiscalizacaoNotificacaoTermo()
    {
        return $this->fkFiscalizacaoNotificacaoTermo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoInfracao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Infracao $fkFiscalizacaoInfracao
     * @return NotificacaoTermoInfracao
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
}
