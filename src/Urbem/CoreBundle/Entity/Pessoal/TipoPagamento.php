<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * TipoPagamento
 */
class TipoPagamento
{
    /**
     * PK
     * @var integer
     */
    private $codTipoPagamento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoServidores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoPagamento
     *
     * @param integer $codTipoPagamento
     * @return TipoPagamento
     */
    public function setCodTipoPagamento($codTipoPagamento)
    {
        $this->codTipoPagamento = $codTipoPagamento;
        return $this;
    }

    /**
     * Get codTipoPagamento
     *
     * @return integer
     */
    public function getCodTipoPagamento()
    {
        return $this->codTipoPagamento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoPagamento
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
     * Add PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return TipoPagamento
     */
    public function addFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        if (false === $this->fkPessoalContratoServidores->contains($fkPessoalContratoServidor)) {
            $fkPessoalContratoServidor->setFkPessoalTipoPagamento($this);
            $this->fkPessoalContratoServidores->add($fkPessoalContratoServidor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     */
    public function removeFkPessoalContratoServidores(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->fkPessoalContratoServidores->removeElement($fkPessoalContratoServidor);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidores()
    {
        return $this->fkPessoalContratoServidores;
    }
}
