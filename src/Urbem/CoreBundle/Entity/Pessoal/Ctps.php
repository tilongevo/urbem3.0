<?php

namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Ctps
 */
class Ctps
{
    /**
     * PK
     * @var integer
     */
    private $codCtps;

    /**
     * @var string
     */
    private $numero;

    /**
     * @var \DateTime
     */
    private $dtEmissao;

    /**
     * @var string
     */
    private $orgaoExpedidor;

    /**
     * @var string
     */
    private $serie;

    /**
     * @var integer
     */
    private $ufExpedicao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorCtps
     */
    private $fkPessoalServidorCtps;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwUf
     */
    private $fkSwUf;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalServidorCtps = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codCtps
     *
     * @param integer $codCtps
     * @return Ctps
     */
    public function setCodCtps($codCtps)
    {
        $this->codCtps = $codCtps;
        return $this;
    }

    /**
     * Get codCtps
     *
     * @return integer
     */
    public function getCodCtps()
    {
        return $this->codCtps;
    }

    /**
     * Set numero
     *
     * @param string $numero
     * @return Ctps
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set dtEmissao
     *
     * @param \DateTime $dtEmissao
     * @return Ctps
     */
    public function setDtEmissao(\DateTime $dtEmissao)
    {
        $this->dtEmissao = $dtEmissao;
        return $this;
    }

    /**
     * Get dtEmissao
     *
     * @return \DateTime
     */
    public function getDtEmissao()
    {
        return $this->dtEmissao;
    }

    /**
     * Set orgaoExpedidor
     *
     * @param string $orgaoExpedidor
     * @return Ctps
     */
    public function setOrgaoExpedidor($orgaoExpedidor)
    {
        $this->orgaoExpedidor = $orgaoExpedidor;
        return $this;
    }

    /**
     * Get orgaoExpedidor
     *
     * @return string
     */
    public function getOrgaoExpedidor()
    {
        return $this->orgaoExpedidor;
    }

    /**
     * Set serie
     *
     * @param string $serie
     * @return Ctps
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * Get serie
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set ufExpedicao
     *
     * @param integer $ufExpedicao
     * @return Ctps
     */
    public function setUfExpedicao($ufExpedicao = null)
    {
        $this->ufExpedicao = $ufExpedicao;
        return $this;
    }

    /**
     * Get ufExpedicao
     *
     * @return integer
     */
    public function getUfExpedicao()
    {
        return $this->ufExpedicao;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalServidorCtps
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorCtps $fkPessoalServidorCtps
     * @return Ctps
     */
    public function addFkPessoalServidorCtps(\Urbem\CoreBundle\Entity\Pessoal\ServidorCtps $fkPessoalServidorCtps)
    {
        if (false === $this->fkPessoalServidorCtps->contains($fkPessoalServidorCtps)) {
            $fkPessoalServidorCtps->setFkPessoalCtps($this);
            $this->fkPessoalServidorCtps->add($fkPessoalServidorCtps);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalServidorCtps
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ServidorCtps $fkPessoalServidorCtps
     */
    public function removeFkPessoalServidorCtps(\Urbem\CoreBundle\Entity\Pessoal\ServidorCtps $fkPessoalServidorCtps)
    {
        $this->fkPessoalServidorCtps->removeElement($fkPessoalServidorCtps);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalServidorCtps
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ServidorCtps
     */
    public function getFkPessoalServidorCtps()
    {
        return $this->fkPessoalServidorCtps;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwUf
     *
     * @param \Urbem\CoreBundle\Entity\SwUf $fkSwUf
     * @return Ctps
     */
    public function setFkSwUf(\Urbem\CoreBundle\Entity\SwUf $fkSwUf)
    {
        $this->ufExpedicao = $fkSwUf->getCodUf();
        $this->fkSwUf = $fkSwUf;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwUf
     *
     * @return \Urbem\CoreBundle\Entity\SwUf
     */
    public function getFkSwUf()
    {
        return $this->fkSwUf;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->serie;
    }
}
