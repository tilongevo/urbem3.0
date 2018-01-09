<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Previdencia
 */
class Previdencia
{
    /**
     * PK
     * @var integer
     */
    private $codPrevidencia;

    /**
     * @var integer
     */
    private $codVinculo;

    /**
     * @var integer
     */
    private $codRegimePrevidencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    private $fkFolhapagamentoPrevidenciaPrevidencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia
     */
    private $fkPessoalContratoPensionistaPrevidencias;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia
     */
    private $fkPessoalContratoServidorPrevidencias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Vinculo
     */
    private $fkFolhapagamentoVinculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia
     */
    private $fkFolhapagamentoRegimePrevidencia;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoPrevidenciaPrevidencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoPensionistaPrevidencias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPessoalContratoServidorPrevidencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPrevidencia
     *
     * @param integer $codPrevidencia
     * @return Previdencia
     */
    public function setCodPrevidencia($codPrevidencia)
    {
        $this->codPrevidencia = $codPrevidencia;
        return $this;
    }

    /**
     * Get codPrevidencia
     *
     * @return integer
     */
    public function getCodPrevidencia()
    {
        return $this->codPrevidencia;
    }

    /**
     * Set codVinculo
     *
     * @param integer $codVinculo
     * @return Previdencia
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
     * Set codRegimePrevidencia
     *
     * @param integer $codRegimePrevidencia
     * @return Previdencia
     */
    public function setCodRegimePrevidencia($codRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $codRegimePrevidencia;
        return $this;
    }

    /**
     * Get codRegimePrevidencia
     *
     * @return integer
     */
    public function getCodRegimePrevidencia()
    {
        return $this->codRegimePrevidencia;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoPrevidenciaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia
     * @return Previdencia
     */
    public function addFkFolhapagamentoPrevidenciaPrevidencias(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia)
    {
        if (false === $this->fkFolhapagamentoPrevidenciaPrevidencias->contains($fkFolhapagamentoPrevidenciaPrevidencia)) {
            $fkFolhapagamentoPrevidenciaPrevidencia->setFkFolhapagamentoPrevidencia($this);
            $this->fkFolhapagamentoPrevidenciaPrevidencias->add($fkFolhapagamentoPrevidenciaPrevidencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoPrevidenciaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia
     */
    public function removeFkFolhapagamentoPrevidenciaPrevidencias(\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia $fkFolhapagamentoPrevidenciaPrevidencia)
    {
        $this->fkFolhapagamentoPrevidenciaPrevidencias->removeElement($fkFolhapagamentoPrevidenciaPrevidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoPrevidenciaPrevidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\PrevidenciaPrevidencia
     */
    public function getFkFolhapagamentoPrevidenciaPrevidencias()
    {
        return $this->fkFolhapagamentoPrevidenciaPrevidencias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoPensionistaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia $fkPessoalContratoPensionistaPrevidencia
     * @return Previdencia
     */
    public function addFkPessoalContratoPensionistaPrevidencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia $fkPessoalContratoPensionistaPrevidencia)
    {
        if (false === $this->fkPessoalContratoPensionistaPrevidencias->contains($fkPessoalContratoPensionistaPrevidencia)) {
            $fkPessoalContratoPensionistaPrevidencia->setFkFolhapagamentoPrevidencia($this);
            $this->fkPessoalContratoPensionistaPrevidencias->add($fkPessoalContratoPensionistaPrevidencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoPensionistaPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia $fkPessoalContratoPensionistaPrevidencia
     */
    public function removeFkPessoalContratoPensionistaPrevidencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia $fkPessoalContratoPensionistaPrevidencia)
    {
        $this->fkPessoalContratoPensionistaPrevidencias->removeElement($fkPessoalContratoPensionistaPrevidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoPensionistaPrevidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia
     */
    public function getFkPessoalContratoPensionistaPrevidencias()
    {
        return $this->fkPessoalContratoPensionistaPrevidencias;
    }

    /**
     * OneToMany (owning side)
     * Add PessoalContratoServidorPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia $fkPessoalContratoServidorPrevidencia
     * @return Previdencia
     */
    public function addFkPessoalContratoServidorPrevidencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia $fkPessoalContratoServidorPrevidencia)
    {
        if (false === $this->fkPessoalContratoServidorPrevidencias->contains($fkPessoalContratoServidorPrevidencia)) {
            $fkPessoalContratoServidorPrevidencia->setFkFolhapagamentoPrevidencia($this);
            $this->fkPessoalContratoServidorPrevidencias->add($fkPessoalContratoServidorPrevidencia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorPrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia $fkPessoalContratoServidorPrevidencia
     */
    public function removeFkPessoalContratoServidorPrevidencias(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia $fkPessoalContratoServidorPrevidencia)
    {
        $this->fkPessoalContratoServidorPrevidencias->removeElement($fkPessoalContratoServidorPrevidencia);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorPrevidencias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia
     */
    public function getFkPessoalContratoServidorPrevidencias()
    {
        return $this->fkPessoalContratoServidorPrevidencias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoVinculo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Vinculo $fkFolhapagamentoVinculo
     * @return Previdencia
     */
    public function setFkFolhapagamentoVinculo(\Urbem\CoreBundle\Entity\Folhapagamento\Vinculo $fkFolhapagamentoVinculo)
    {
        $this->codVinculo = $fkFolhapagamentoVinculo->getCodVinculo();
        $this->fkFolhapagamentoVinculo = $fkFolhapagamentoVinculo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoVinculo
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Vinculo
     */
    public function getFkFolhapagamentoVinculo()
    {
        return $this->fkFolhapagamentoVinculo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoRegimePrevidencia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia $fkFolhapagamentoRegimePrevidencia
     * @return Previdencia
     */
    public function setFkFolhapagamentoRegimePrevidencia(\Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia $fkFolhapagamentoRegimePrevidencia)
    {
        $this->codRegimePrevidencia = $fkFolhapagamentoRegimePrevidencia->getCodRegimePrevidencia();
        $this->fkFolhapagamentoRegimePrevidencia = $fkFolhapagamentoRegimePrevidencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoRegimePrevidencia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia
     */
    public function getFkFolhapagamentoRegimePrevidencia()
    {
        return $this->fkFolhapagamentoRegimePrevidencia;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '%s - %s',
            $this->getCodPrevidencia(),
            $this->getFkFolhapagamentoRegimePrevidencia()->getDescricao()
        );
    }
}
