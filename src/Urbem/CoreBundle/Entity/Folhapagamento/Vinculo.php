<?php

namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Vinculo
 */
class Vinculo
{
    /**
     * PK
     * @var integer
     */
    private $codVinculo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    private $fkFolhapagamentoPrevidencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoPrevidencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codVinculo
     *
     * @param integer $codVinculo
     * @return Vinculo
     */
    public function setCodVinculo($codVinculo)
    {
        $this->codVinculo = $codVinculo;
        return $this;
    }

    /**
     * Get codVinculo
     *
     * @return integer
     */
    public function getCodVinculo()
    {
        return $this->codVinculo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Vinculo
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
     * @param \Doctrine\Common\Collections\Collection $previdencia
     * @return Vinculo
     */
    public function setFkFolhapagamentoPrevidencias(\Doctrine\Common\Collections\Collection $previdencias)
    {
        foreach ($previdencias as $previdencia) {
            $this->addFkFolhapagamentoPrevidencias($previdencia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia
     * @return Vinculo
     */
    public function addFkFolhapagamentoPrevidencias(\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia)
    {
        if (false === $this->fkFolhapagamentoPrevidencias->contains($fkFolhapagamentoPrevidencia)) {
            $fkFolhapagamentoPrevidencia->setFkFolhapagamentoVinculo($this);
            $this->fkFolhapagamentoPrevidencias->add($fkFolhapagamentoPrevidencia);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia
     */
    public function removeFkFolhapagamentoPrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia $fkFolhapagamentoPrevidencia)
    {
        $this->fkFolhapagamentoPrevidencias->removeElement($fkFolhapagamentoPrevidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPrevidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\Previdencia
     */
    public function getFkFolhapagamentoPrevidencias()
    {
        return $this->fkFolhapagamentoPrevidencias;
    }
}
