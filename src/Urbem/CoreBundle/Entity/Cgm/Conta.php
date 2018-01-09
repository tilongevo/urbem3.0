<?php
 
namespace Urbem\CoreBundle\Entity\Cgm;

/**
 * Conta
 */
class Conta
{
    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * PK
     * @var integer
     */
    private $codAgencia;

    /**
     * PK
     * @var integer
     */
    private $codBanco;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $numConta;

    /**
     * @var \DateTime
     */
    private $dtCriacao = '2006-09-05';

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\ContaCgm
     */
    private $fkCgmContaCgns;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    private $fkMonetarioAgencia;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cgm\TipoConta
     */
    private $fkCgmTipoConta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkCgmContaCgns = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dtCriacao = new \DateTime;
    }

    /**
     * Set codConta
     *
     * @param integer $codConta
     * @return Conta
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * Set codAgencia
     *
     * @param integer $codAgencia
     * @return Conta
     */
    public function setCodAgencia($codAgencia)
    {
        $this->codAgencia = $codAgencia;
        return $this;
    }

    /**
     * Get codAgencia
     *
     * @return integer
     */
    public function getCodAgencia()
    {
        return $this->codAgencia;
    }

    /**
     * Set codBanco
     *
     * @param integer $codBanco
     * @return Conta
     */
    public function setCodBanco($codBanco)
    {
        $this->codBanco = $codBanco;
        return $this;
    }

    /**
     * Get codBanco
     *
     * @return integer
     */
    public function getCodBanco()
    {
        return $this->codBanco;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Conta
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set numConta
     *
     * @param string $numConta
     * @return Conta
     */
    public function setNumConta($numConta)
    {
        $this->numConta = $numConta;
        return $this;
    }

    /**
     * Get numConta
     *
     * @return string
     */
    public function getNumConta()
    {
        return $this->numConta;
    }

    /**
     * Set dtCriacao
     *
     * @param \DateTime $dtCriacao
     * @return Conta
     */
    public function setDtCriacao(\DateTime $dtCriacao = null)
    {
        $this->dtCriacao = $dtCriacao;
        return $this;
    }

    /**
     * Get dtCriacao
     *
     * @return \DateTime
     */
    public function getDtCriacao()
    {
        return $this->dtCriacao;
    }

    /**
     * OneToMany (owning side)
     * Add CgmContaCgm
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\ContaCgm $fkCgmContaCgm
     * @return Conta
     */
    public function addFkCgmContaCgns(\Urbem\CoreBundle\Entity\Cgm\ContaCgm $fkCgmContaCgm)
    {
        if (false === $this->fkCgmContaCgns->contains($fkCgmContaCgm)) {
            $fkCgmContaCgm->setFkCgmConta($this);
            $this->fkCgmContaCgns->add($fkCgmContaCgm);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove CgmContaCgm
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\ContaCgm $fkCgmContaCgm
     */
    public function removeFkCgmContaCgns(\Urbem\CoreBundle\Entity\Cgm\ContaCgm $fkCgmContaCgm)
    {
        $this->fkCgmContaCgns->removeElement($fkCgmContaCgm);
    }

    /**
     * OneToMany (owning side)
     * Get fkCgmContaCgns
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Cgm\ContaCgm
     */
    public function getFkCgmContaCgns()
    {
        return $this->fkCgmContaCgns;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioAgencia
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia
     * @return Conta
     */
    public function setFkMonetarioAgencia(\Urbem\CoreBundle\Entity\Monetario\Agencia $fkMonetarioAgencia)
    {
        $this->codBanco = $fkMonetarioAgencia->getCodBanco();
        $this->codAgencia = $fkMonetarioAgencia->getCodAgencia();
        $this->fkMonetarioAgencia = $fkMonetarioAgencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioAgencia
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Agencia
     */
    public function getFkMonetarioAgencia()
    {
        return $this->fkMonetarioAgencia;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCgmTipoConta
     *
     * @param \Urbem\CoreBundle\Entity\Cgm\TipoConta $fkCgmTipoConta
     * @return Conta
     */
    public function setFkCgmTipoConta(\Urbem\CoreBundle\Entity\Cgm\TipoConta $fkCgmTipoConta)
    {
        $this->codTipo = $fkCgmTipoConta->getCodTipo();
        $this->fkCgmTipoConta = $fkCgmTipoConta;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCgmTipoConta
     *
     * @return \Urbem\CoreBundle\Entity\Cgm\TipoConta
     */
    public function getFkCgmTipoConta()
    {
        return $this->fkCgmTipoConta;
    }
}
