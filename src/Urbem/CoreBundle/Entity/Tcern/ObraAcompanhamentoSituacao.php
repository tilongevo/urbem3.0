<?php
 
namespace Urbem\CoreBundle\Entity\Tcern;

/**
 * ObraAcompanhamentoSituacao
 */
class ObraAcompanhamentoSituacao
{
    /**
     * PK
     * @var integer
     */
    private $codSituacao;

    /**
     * @var string
     */
    private $situacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento
     */
    private $fkTcernObraAcompanhamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcernObraAcompanhamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return ObraAcompanhamentoSituacao
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set situacao
     *
     * @param string $situacao
     * @return ObraAcompanhamentoSituacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
        return $this;
    }

    /**
     * Get situacao
     *
     * @return string
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * OneToMany (owning side)
     * Add TcernObraAcompanhamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento
     * @return ObraAcompanhamentoSituacao
     */
    public function addFkTcernObraAcompanhamentos(\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento)
    {
        if (false === $this->fkTcernObraAcompanhamentos->contains($fkTcernObraAcompanhamento)) {
            $fkTcernObraAcompanhamento->setFkTcernObraAcompanhamentoSituacao($this);
            $this->fkTcernObraAcompanhamentos->add($fkTcernObraAcompanhamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcernObraAcompanhamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento
     */
    public function removeFkTcernObraAcompanhamentos(\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento $fkTcernObraAcompanhamento)
    {
        $this->fkTcernObraAcompanhamentos->removeElement($fkTcernObraAcompanhamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcernObraAcompanhamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcern\ObraAcompanhamento
     */
    public function getFkTcernObraAcompanhamentos()
    {
        return $this->fkTcernObraAcompanhamentos;
    }
}
