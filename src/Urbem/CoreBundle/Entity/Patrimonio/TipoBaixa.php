<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * TipoBaixa
 */
class TipoBaixa
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
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemBaixado
     */
    private $fkPatrimonioBemBaixados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioBemBaixados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoBaixa
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
     * @return TipoBaixa
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
     * Add PatrimonioBemBaixado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemBaixado $fkPatrimonioBemBaixado
     * @return TipoBaixa
     */
    public function addFkPatrimonioBemBaixados(\Urbem\CoreBundle\Entity\Patrimonio\BemBaixado $fkPatrimonioBemBaixado)
    {
        if (false === $this->fkPatrimonioBemBaixados->contains($fkPatrimonioBemBaixado)) {
            $fkPatrimonioBemBaixado->setFkPatrimonioTipoBaixa($this);
            $this->fkPatrimonioBemBaixados->add($fkPatrimonioBemBaixado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioBemBaixado
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\BemBaixado $fkPatrimonioBemBaixado
     */
    public function removeFkPatrimonioBemBaixados(\Urbem\CoreBundle\Entity\Patrimonio\BemBaixado $fkPatrimonioBemBaixado)
    {
        $this->fkPatrimonioBemBaixados->removeElement($fkPatrimonioBemBaixado);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioBemBaixados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\BemBaixado
     */
    public function getFkPatrimonioBemBaixados()
    {
        return $this->fkPatrimonioBemBaixados;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!is_null($this->fkPatrimonioBemBaixados)) {
            return (string) $this->descricao;
        }
        return 'Baixa';
    }
}
