<?php
 
namespace Urbem\CoreBundle\Entity;

/**
 * SwSituacaoProcesso
 */
class SwSituacaoProcesso
{
    const EM_ANDAMENTO_RECEBER = 2;
    const EM_ANDAMENTO_RECEBIDO = 3;
    const APENSADO = 4;
    const ARQUIVADO_TEMPORARIO = 5;
    const ARQUIVADO_DEFINITIVO = 9;

    /**
     * PK
     * @var integer
     */
    private $codSituacao;

    /**
     * @var string
     */
    private $nomSituacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamento
     */
    private $fkSwAndamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcesso
     */
    private $fkSwProcessos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkSwAndamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkSwProcessos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return SwSituacaoProcesso
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
     * Set nomSituacao
     *
     * @param string $nomSituacao
     * @return SwSituacaoProcesso
     */
    public function setNomSituacao($nomSituacao)
    {
        $this->nomSituacao = $nomSituacao;
        return $this;
    }

    /**
     * Get nomSituacao
     *
     * @return string
     */
    public function getNomSituacao()
    {
        return $this->nomSituacao;
    }

    /**
     * OneToMany (owning side)
     * Add SwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     * @return SwSituacaoProcesso
     */
    public function addFkSwAndamentos(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        if (false === $this->fkSwAndamentos->contains($fkSwAndamento)) {
            $fkSwAndamento->setFkSwSituacaoProcesso($this);
            $this->fkSwAndamentos->add($fkSwAndamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwAndamento
     *
     * @param \Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento
     */
    public function removeFkSwAndamentos(\Urbem\CoreBundle\Entity\SwAndamento $fkSwAndamento)
    {
        $this->fkSwAndamentos->removeElement($fkSwAndamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwAndamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwAndamento
     */
    public function getFkSwAndamentos()
    {
        return $this->fkSwAndamentos;
    }

    /**
     * OneToMany (owning side)
     * Add SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     * @return SwSituacaoProcesso
     */
    public function addFkSwProcessos(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        if (false === $this->fkSwProcessos->contains($fkSwProcesso)) {
            $fkSwProcesso->setFkSwSituacaoProcesso($this);
            $this->fkSwProcessos->add($fkSwProcesso);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove SwProcesso
     *
     * @param \Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso
     */
    public function removeFkSwProcessos(\Urbem\CoreBundle\Entity\SwProcesso $fkSwProcesso)
    {
        $this->fkSwProcessos->removeElement($fkSwProcesso);
    }

    /**
     * OneToMany (owning side)
     * Get fkSwProcessos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\SwProcesso
     */
    public function getFkSwProcessos()
    {
        return $this->fkSwProcessos;
    }
}
