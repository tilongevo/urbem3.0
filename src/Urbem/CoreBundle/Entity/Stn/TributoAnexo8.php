<?php
 
namespace Urbem\CoreBundle\Entity\Stn;

/**
 * TributoAnexo8
 */
class TributoAnexo8
{
    /**
     * PK
     * @var integer
     */
    private $codTributo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos
     */
    private $fkStnContaDedutoraTributos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkStnContaDedutoraTributos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTributo
     *
     * @param integer $codTributo
     * @return TributoAnexo8
     */
    public function setCodTributo($codTributo)
    {
        $this->codTributo = $codTributo;
        return $this;
    }

    /**
     * Get codTributo
     *
     * @return integer
     */
    public function getCodTributo()
    {
        return $this->codTributo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TributoAnexo8
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
     * Add StnContaDedutoraTributos
     *
     * @param \Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos $fkStnContaDedutoraTributos
     * @return TributoAnexo8
     */
    public function addFkStnContaDedutoraTributos(\Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos $fkStnContaDedutoraTributos)
    {
        if (false === $this->fkStnContaDedutoraTributos->contains($fkStnContaDedutoraTributos)) {
            $fkStnContaDedutoraTributos->setFkStnTributoAnexo8($this);
            $this->fkStnContaDedutoraTributos->add($fkStnContaDedutoraTributos);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove StnContaDedutoraTributos
     *
     * @param \Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos $fkStnContaDedutoraTributos
     */
    public function removeFkStnContaDedutoraTributos(\Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos $fkStnContaDedutoraTributos)
    {
        $this->fkStnContaDedutoraTributos->removeElement($fkStnContaDedutoraTributos);
    }

    /**
     * OneToMany (owning side)
     * Get fkStnContaDedutoraTributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Stn\ContaDedutoraTributos
     */
    public function getFkStnContaDedutoraTributos()
    {
        return $this->fkStnContaDedutoraTributos;
    }
}
