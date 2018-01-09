<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Requisito
 */
class Requisito
{
    /**
     * PK
     * @var integer
     */
    private $codRequisito;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoRequisito
     */
    private $fkPessoalCargoRequisitos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalCargoRequisitos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codRequisito
     *
     * @param integer $codRequisito
     * @return Requisito
     */
    public function setCodRequisito($codRequisito)
    {
        $this->codRequisito = $codRequisito;
        return $this;
    }

    /**
     * Get codRequisito
     *
     * @return integer
     */
    public function getCodRequisito()
    {
        return $this->codRequisito;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Requisito
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
     * Add PessoalCargoRequisito
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoRequisito $fkPessoalCargoRequisito
     * @return Requisito
     */
    public function addFkPessoalCargoRequisitos(\Urbem\CoreBundle\Entity\Pessoal\CargoRequisito $fkPessoalCargoRequisito)
    {
        if (false === $this->fkPessoalCargoRequisitos->contains($fkPessoalCargoRequisito)) {
            $fkPessoalCargoRequisito->setFkPessoalRequisito($this);
            $this->fkPessoalCargoRequisitos->add($fkPessoalCargoRequisito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalCargoRequisito
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\CargoRequisito $fkPessoalCargoRequisito
     */
    public function removeFkPessoalCargoRequisitos(\Urbem\CoreBundle\Entity\Pessoal\CargoRequisito $fkPessoalCargoRequisito)
    {
        $this->fkPessoalCargoRequisitos->removeElement($fkPessoalCargoRequisito);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalCargoRequisitos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\CargoRequisito
     */
    public function getFkPessoalCargoRequisitos()
    {
        return $this->fkPessoalCargoRequisitos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
