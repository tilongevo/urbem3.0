<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * MedidasObra
 */
class MedidasObra
{
    /**
     * PK
     * @var integer
     */
    private $codMedida;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao
     */
    private $fkTcmbaObraMedicoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkTcmbaObraMedicoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codMedida
     *
     * @param integer $codMedida
     * @return MedidasObra
     */
    public function setCodMedida($codMedida)
    {
        $this->codMedida = $codMedida;
        return $this;
    }

    /**
     * Get codMedida
     *
     * @return integer
     */
    public function getCodMedida()
    {
        return $this->codMedida;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return MedidasObra
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
     * Add TcmbaObraMedicao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao
     * @return MedidasObra
     */
    public function addFkTcmbaObraMedicoes(\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao)
    {
        if (false === $this->fkTcmbaObraMedicoes->contains($fkTcmbaObraMedicao)) {
            $fkTcmbaObraMedicao->setFkTcmbaMedidasObra($this);
            $this->fkTcmbaObraMedicoes->add($fkTcmbaObraMedicao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove TcmbaObraMedicao
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao
     */
    public function removeFkTcmbaObraMedicoes(\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao $fkTcmbaObraMedicao)
    {
        $this->fkTcmbaObraMedicoes->removeElement($fkTcmbaObraMedicao);
    }

    /**
     * OneToMany (owning side)
     * Get fkTcmbaObraMedicoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Tcmba\ObraMedicao
     */
    public function getFkTcmbaObraMedicoes()
    {
        return $this->fkTcmbaObraMedicoes;
    }
}
