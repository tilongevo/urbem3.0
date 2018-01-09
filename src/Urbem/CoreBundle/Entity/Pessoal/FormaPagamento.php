<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * FormaPagamento
 */
class FormaPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codFormaPagamento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento
     */
    private $fkPessoalContratoServidorFormaPagamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoServidorFormaPagamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFormaPagamento
     *
     * @param integer $codFormaPagamento
     * @return FormaPagamento
     */
    public function setCodFormaPagamento($codFormaPagamento)
    {
        $this->codFormaPagamento = $codFormaPagamento;
        return $this;
    }

    /**
     * Get codFormaPagamento
     *
     * @return integer
     */
    public function getCodFormaPagamento()
    {
        return $this->codFormaPagamento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return FormaPagamento
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
     * Add PessoalContratoServidorFormaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento $fkPessoalContratoServidorFormaPagamento
     * @return FormaPagamento
     */
    public function addFkPessoalContratoServidorFormaPagamentos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento $fkPessoalContratoServidorFormaPagamento)
    {
        if (false === $this->fkPessoalContratoServidorFormaPagamentos->contains($fkPessoalContratoServidorFormaPagamento)) {
            $fkPessoalContratoServidorFormaPagamento->setFkPessoalFormaPagamento($this);
            $this->fkPessoalContratoServidorFormaPagamentos->add($fkPessoalContratoServidorFormaPagamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorFormaPagamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento $fkPessoalContratoServidorFormaPagamento
     */
    public function removeFkPessoalContratoServidorFormaPagamentos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento $fkPessoalContratoServidorFormaPagamento)
    {
        $this->fkPessoalContratoServidorFormaPagamentos->removeElement($fkPessoalContratoServidorFormaPagamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorFormaPagamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorFormaPagamento
     */
    public function getFkPessoalContratoServidorFormaPagamentos()
    {
        return $this->fkPessoalContratoServidorFormaPagamentos;
    }
}
