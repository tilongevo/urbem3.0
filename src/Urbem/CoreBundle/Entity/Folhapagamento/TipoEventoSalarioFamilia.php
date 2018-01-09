<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoEventoSalarioFamilia
 */
class TipoEventoSalarioFamilia
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento
     */
    private $fkFolhapagamentoSalarioFamiliaEventos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoSalarioFamiliaEventos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoEventoSalarioFamilia
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
     * @return TipoEventoSalarioFamilia
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
     * Add FolhapagamentoSalarioFamiliaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento
     * @return TipoEventoSalarioFamilia
     */
    public function addFkFolhapagamentoSalarioFamiliaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento)
    {
        if (false === $this->fkFolhapagamentoSalarioFamiliaEventos->contains($fkFolhapagamentoSalarioFamiliaEvento)) {
            $fkFolhapagamentoSalarioFamiliaEvento->setFkFolhapagamentoTipoEventoSalarioFamilia($this);
            $this->fkFolhapagamentoSalarioFamiliaEventos->add($fkFolhapagamentoSalarioFamiliaEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoSalarioFamiliaEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento
     */
    public function removeFkFolhapagamentoSalarioFamiliaEventos(\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento $fkFolhapagamentoSalarioFamiliaEvento)
    {
        $this->fkFolhapagamentoSalarioFamiliaEventos->removeElement($fkFolhapagamentoSalarioFamiliaEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoSalarioFamiliaEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento
     */
    public function getFkFolhapagamentoSalarioFamiliaEventos()
    {
        return $this->fkFolhapagamentoSalarioFamiliaEventos;
    }
}
