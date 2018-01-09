<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Modalidade
 */
class Modalidade
{
    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var DateTimeMicrosecondPK
     */
    private $ultimoTimestamp;

    /**
     * @var boolean
     */
    private $ativa = true;

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
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Modalidade
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Modalidade
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
     * Set ultimoTimestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $ultimoTimestamp
     * @return Modalidade
     */
    public function setUltimoTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $ultimoTimestamp = null)
    {
        $this->ultimoTimestamp = $ultimoTimestamp;
        return $this;
    }

    /**
     * Get ultimoTimestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getUltimoTimestamp()
    {
        return $this->ultimoTimestamp;
    }

    /**
     * Set ativa
     *
     * @param boolean $ativa
     * @return Modalidade
     */
    public function setAtiva($ativa)
    {
        $this->ativa = $ativa;
        return $this;
    }

    /**
     * Get ativa
     *
     * @return boolean
     */
    public function getAtiva()
    {
        return $this->ativa;
    }

    /**
     * OneToMany (owning side)
     * Add DividaModalidadeVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia
     * @return Modalidade
     */
    public function addFkDividaModalidadeVigencias(\Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia $fkDividaModalidadeVigencia)
    {
        if (false === $this->fkDividaModalidadeVigencias->contains($fkDividaModalidadeVigencia)) {
            $fkDividaModalidadeVigencia->setFkDividaModalidade($this);
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

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->descricao;
    }
}
