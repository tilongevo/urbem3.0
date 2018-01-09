<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoDecimo
 */
class TipoEventoDecimo
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento
     */
    private $fkFolhapagamentoDecimoEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoDecimoEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoDecimo
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
     * @return TipoEventoDecimo
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
     * Add FolhapagamentoDecimoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento $fkFolhapagamentoDecimoEvento
     * @return TipoEventoDecimo
     */
    public function addFkFolhapagamentoDecimoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento $fkFolhapagamentoDecimoEvento)
    {
        if (false === $this->fkFolhapagamentoDecimoEventos->contains($fkFolhapagamentoDecimoEvento)) {
            $fkFolhapagamentoDecimoEvento->setFkFolhapagamentoTipoEventoDecimo($this);
            $this->fkFolhapagamentoDecimoEventos->add($fkFolhapagamentoDecimoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoDecimoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento $fkFolhapagamentoDecimoEvento
     */
    public function removeFkFolhapagamentoDecimoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento $fkFolhapagamentoDecimoEvento)
    {
        $this->fkFolhapagamentoDecimoEventos->removeElement($fkFolhapagamentoDecimoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoDecimoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento
     */
    public function getFkFolhapagamentoDecimoEventos()
    {
        return $this->fkFolhapagamentoDecimoEventos;
    }
}
