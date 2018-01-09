<?php
 
namespace Urbem\CoreBundle\Entity\Empenho;

/**
 * TipoDocumento
 */
class TipoDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    private $fkEmpenhoItemPrestacaoContas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEmpenhoItemPrestacaoContas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return TipoDocumento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoDocumento
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
     * Add EmpenhoItemPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas
     * @return TipoDocumento
     */
    public function addFkEmpenhoItemPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas)
    {
        if (false === $this->fkEmpenhoItemPrestacaoContas->contains($fkEmpenhoItemPrestacaoContas)) {
            $fkEmpenhoItemPrestacaoContas->setFkEmpenhoTipoDocumento($this);
            $this->fkEmpenhoItemPrestacaoContas->add($fkEmpenhoItemPrestacaoContas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EmpenhoItemPrestacaoContas
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas
     */
    public function removeFkEmpenhoItemPrestacaoContas(\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas $fkEmpenhoItemPrestacaoContas)
    {
        $this->fkEmpenhoItemPrestacaoContas->removeElement($fkEmpenhoItemPrestacaoContas);
    }

    /**
     * OneToMany (owning side)
     * Get fkEmpenhoItemPrestacaoContas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Empenho\ItemPrestacaoContas
     */
    public function getFkEmpenhoItemPrestacaoContas()
    {
        return $this->fkEmpenhoItemPrestacaoContas;
    }
}
