<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConstrucaoOutros
 */
class ConstrucaoOutros
{
    /**
     * PK
     * @var integer
     */
    private $codConstrucao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    private $fkImobiliarioConstrucao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor
     */
    private $fkImobiliarioAtributoConstrucaoOutrosValores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoConstrucaoOutrosValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConstrucao
     *
     * @param integer $codConstrucao
     * @return ConstrucaoOutros
     */
    public function setCodConstrucao($codConstrucao)
    {
        $this->codConstrucao = $codConstrucao;
        return $this;
    }

    /**
     * Get codConstrucao
     *
     * @return integer
     */
    public function getCodConstrucao()
    {
        return $this->codConstrucao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ConstrucaoOutros
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
     * Add ImobiliarioAtributoConstrucaoOutrosValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor $fkImobiliarioAtributoConstrucaoOutrosValor
     * @return ConstrucaoOutros
     */
    public function addFkImobiliarioAtributoConstrucaoOutrosValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor $fkImobiliarioAtributoConstrucaoOutrosValor)
    {
        if (false === $this->fkImobiliarioAtributoConstrucaoOutrosValores->contains($fkImobiliarioAtributoConstrucaoOutrosValor)) {
            $fkImobiliarioAtributoConstrucaoOutrosValor->setFkImobiliarioConstrucaoOutros($this);
            $this->fkImobiliarioAtributoConstrucaoOutrosValores->add($fkImobiliarioAtributoConstrucaoOutrosValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoConstrucaoOutrosValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor $fkImobiliarioAtributoConstrucaoOutrosValor
     */
    public function removeFkImobiliarioAtributoConstrucaoOutrosValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor $fkImobiliarioAtributoConstrucaoOutrosValor)
    {
        $this->fkImobiliarioAtributoConstrucaoOutrosValores->removeElement($fkImobiliarioAtributoConstrucaoOutrosValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoConstrucaoOutrosValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor
     */
    public function getFkImobiliarioAtributoConstrucaoOutrosValores()
    {
        return $this->fkImobiliarioAtributoConstrucaoOutrosValores;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioConstrucao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao
     * @return ConstrucaoOutros
     */
    public function setFkImobiliarioConstrucao(\Urbem\CoreBundle\Entity\Imobiliario\Construcao $fkImobiliarioConstrucao)
    {
        $this->codConstrucao = $fkImobiliarioConstrucao->getCodConstrucao();
        $this->fkImobiliarioConstrucao = $fkImobiliarioConstrucao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioConstrucao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Construcao
     */
    public function getFkImobiliarioConstrucao()
    {
        return $this->fkImobiliarioConstrucao;
    }
}
