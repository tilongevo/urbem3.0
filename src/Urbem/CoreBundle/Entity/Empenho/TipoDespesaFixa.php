<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * TipoDespesaFixa
 */
class TipoDespesaFixa
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $complemento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    private $fkEmpenhoDespesasFixas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoDespesasFixas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoDespesaFixa
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
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDespesaFixa
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
     * Set complemento
     *
     * @param string $complemento
     * @return TipoDespesaFixa
     */
    public function setComplemento($complemento)
    {
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Get complemento
     *
     * @return string
     */
    public function getComplemento()
    {
        return $this->complemento;
    }

    /**
     * OneToMany (owning side)
     * Add EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     * @return TipoDespesaFixa
     */
    public function addFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        if (false === $this->fkEmpenhoDespesasFixas->contains($fkEmpenhoDespesasFixas)) {
            $fkEmpenhoDespesasFixas->setFkEmpenhoTipoDespesaFixa($this);
            $this->fkEmpenhoDespesasFixas->add($fkEmpenhoDespesasFixas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoDespesasFixas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas
     */
    public function removeFkEmpenhoDespesasFixas(\Urbem\CoreBundle\Entity\Empenho\DespesasFixas $fkEmpenhoDespesasFixas)
    {
        $this->fkEmpenhoDespesasFixas->removeElement($fkEmpenhoDespesasFixas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoDespesasFixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\DespesasFixas
     */
    public function getFkEmpenhoDespesasFixas()
    {
        return $this->fkEmpenhoDespesasFixas;
    }
}
