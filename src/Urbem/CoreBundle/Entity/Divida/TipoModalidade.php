<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * TipoModalidade
 */
class TipoModalidade
{
    /**
     * PK
     * @var integer
     */
    private $codTipoModalidade;

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
     * Set codTipoModalidade
     *
     * @param integer $codTipoModalidade
     * @return TipoModalidade
     */
    public function setCodTipoModalidade($codTipoModalidade)
    {
        $this->codTipoModalidade = $codTipoModalidade;
        return $this;
    }

    /**
     * Get codTipoModalidade
     *
     * @return integer
     */
    public function getCodTipoModalidade()
    {
        return $this->codTipoModalidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoModalidade
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
     * @return TipoModalidade
     */
    public function addFkDividaModalidadeVigencias(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        if (false === $this->fkDividaModalidadeVigencias->contains($fkDividaModalidadeVigencia)) {
            $fkDividaModalidadeVigencia->setFkDividaTipoModalidade($this);
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
