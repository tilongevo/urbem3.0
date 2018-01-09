<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * SituacaoObra
 */
class SituacaoObra
{
    /**
     * PK
     * @var integer
     */
    private $codSituacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraAndamento
     */
    private $fkTcmbaObraAndamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaObraAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return SituacaoObra
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
     * Set descricao
     *
     * @param string $descricao
     * @return SituacaoObra
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
     * Add TcmbaObraAndamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraAndamento $fkTcmbaObraAndamento
     * @return SituacaoObra
     */
    public function addFkTcmbaObraAndamentos(\Urbem\CoreBundle\Entity\Tcmba\ObraAndamento $fkTcmbaObraAndamento)
    {
        if (false === $this->fkTcmbaObraAndamentos->contains($fkTcmbaObraAndamento)) {
            $fkTcmbaObraAndamento->setFkTcmbaSituacaoObra($this);
            $this->fkTcmbaObraAndamentos->add($fkTcmbaObraAndamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraAndamento
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraAndamento $fkTcmbaObraAndamento
     */
    public function removeFkTcmbaObraAndamentos(\Urbem\CoreBundle\Entity\Tcmba\ObraAndamento $fkTcmbaObraAndamento)
    {
        $this->fkTcmbaObraAndamentos->removeElement($fkTcmbaObraAndamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraAndamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraAndamento
     */
    public function getFkTcmbaObraAndamentos()
    {
        return $this->fkTcmbaObraAndamentos;
    }
}
