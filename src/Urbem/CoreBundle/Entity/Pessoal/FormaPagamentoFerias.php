<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * FormaPagamentoFerias
 */
class FormaPagamentoFerias
{
    /**
     * PK
     * @var integer
     */
    private $codForma;

    /**
     * @var string
     */
    private $codigo;

    /**
     * @var integer
     */
    private $dias;

    /**
     * @var integer
     */
    private $abono;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Ferias
     */
    private $fkPessoalFerias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias
     */
    private $fkPessoalConfiguracaoFormaPagamentoFerias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalFerias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalConfiguracaoFormaPagamentoFerias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codForma
     *
     * @param integer $codForma
     * @return FormaPagamentoFerias
     */
    public function setCodForma($codForma)
    {
        $this->codForma = $codForma;
        return $this;
    }

    /**
     * Get codForma
     *
     * @return integer
     */
    public function getCodForma()
    {
        return $this->codForma;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return FormaPagamentoFerias
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set dias
     *
     * @param integer $dias
     * @return FormaPagamentoFerias
     */
    public function setDias($dias)
    {
        $this->dias = $dias;
        return $this;
    }

    /**
     * Get dias
     *
     * @return integer
     */
    public function getDias()
    {
        return $this->dias;
    }

    /**
     * Set abono
     *
     * @param integer $abono
     * @return FormaPagamentoFerias
     */
    public function setAbono($abono)
    {
        $this->abono = $abono;
        return $this;
    }

    /**
     * Get abono
     *
     * @return integer
     */
    public function getAbono()
    {
        return $this->abono;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias
     * @return FormaPagamentoFerias
     */
    public function addFkPessoalFerias(\Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias)
    {
        if (false === $this->fkPessoalFerias->contains($fkPessoalFerias)) {
            $fkPessoalFerias->setFkPessoalFormaPagamentoFerias($this);
            $this->fkPessoalFerias->add($fkPessoalFerias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias
     */
    public function removeFkPessoalFerias(\Urbem\CoreBundle\Entity\Pessoal\Ferias $fkPessoalFerias)
    {
        $this->fkPessoalFerias->removeElement($fkPessoalFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\Ferias
     */
    public function getFkPessoalFerias()
    {
        return $this->fkPessoalFerias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalConfiguracaoFormaPagamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias
     * @return FormaPagamentoFerias
     */
    public function addFkPessoalConfiguracaoFormaPagamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias)
    {
        if (false === $this->fkPessoalConfiguracaoFormaPagamentoFerias->contains($fkPessoalConfiguracaoFormaPagamentoFerias)) {
            $fkPessoalConfiguracaoFormaPagamentoFerias->setFkPessoalFormaPagamentoFerias($this);
            $this->fkPessoalConfiguracaoFormaPagamentoFerias->add($fkPessoalConfiguracaoFormaPagamentoFerias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalConfiguracaoFormaPagamentoFerias
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias
     */
    public function removeFkPessoalConfiguracaoFormaPagamentoFerias(\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias $fkPessoalConfiguracaoFormaPagamentoFerias)
    {
        $this->fkPessoalConfiguracaoFormaPagamentoFerias->removeElement($fkPessoalConfiguracaoFormaPagamentoFerias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalConfiguracaoFormaPagamentoFerias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ConfiguracaoFormaPagamentoFerias
     */
    public function getFkPessoalConfiguracaoFormaPagamentoFerias()
    {
        return $this->fkPessoalConfiguracaoFormaPagamentoFerias;
    }
}
