<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * FormaInscricao
 */
class FormaInscricao
{
    /**
     * PK
     * @var integer
     */
    private $codFormaInscricao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    private $fkDividaModalidadeVigencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkDividaModalidadeVigencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFormaInscricao
     *
     * @param integer $codFormaInscricao
     * @return FormaInscricao
     */
    public function setCodFormaInscricao($codFormaInscricao)
    {
        $this->codFormaInscricao = $codFormaInscricao;
        return $this;
    }

    /**
     * Get codFormaInscricao
     *
     * @return integer
     */
    public function getCodFormaInscricao()
    {
        return $this->codFormaInscricao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return FormaInscricao
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
     * Add DividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return FormaInscricao
     */
    public function addFkDividaModalidadeVigencias(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        if (false === $this->fkDividaModalidadeVigencias->contains($fkDividaModalidadeVigencia)) {
            $fkDividaModalidadeVigencia->setFkDividaFormaInscricao($this);
            $this->fkDividaModalidadeVigencias->add($fkDividaModalidadeVigencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove DividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     */
    public function removeFkDividaModalidadeVigencias(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        $this->fkDividaModalidadeVigencias->removeElement($fkDividaModalidadeVigencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkDividaModalidadeVigencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia
     */
    public function getFkDividaModalidadeVigencias()
    {
        return $this->fkDividaModalidadeVigencias;
    }
}
