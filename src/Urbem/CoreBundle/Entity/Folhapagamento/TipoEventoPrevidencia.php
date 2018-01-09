<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoPrevidencia
 */
class TipoEventoPrevidencia
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento
     */
    private $fkFolhapagamentoPrevidenciaEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoPrevidenciaEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoPrevidencia
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
     * @return TipoEventoPrevidencia
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
     * Add FolhapagamentoPrevidenciaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento
     * @return TipoEventoPrevidencia
     */
    public function addFkFolhapagamentoPrevidenciaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento)
    {
        if (false === $this->fkFolhapagamentoPrevidenciaEventos->contains($fkFolhapagamentoPrevidenciaEvento)) {
            $fkFolhapagamentoPrevidenciaEvento->setFkFolhapagamentoTipoEventoPrevidencia($this);
            $this->fkFolhapagamentoPrevidenciaEventos->add($fkFolhapagamentoPrevidenciaEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPrevidenciaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento
     */
    public function removeFkFolhapagamentoPrevidenciaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento $fkFolhapagamentoPrevidenciaEvento)
    {
        $this->fkFolhapagamentoPrevidenciaEventos->removeElement($fkFolhapagamentoPrevidenciaEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPrevidenciaEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaEvento
     */
    public function getFkFolhapagamentoPrevidenciaEventos()
    {
        return $this->fkFolhapagamentoPrevidenciaEventos;
    }
}
