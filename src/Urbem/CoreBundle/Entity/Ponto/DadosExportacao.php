<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * DadosExportacao
 */
class DadosExportacao
{
    /**
     * PK
     * @var integer
     */
    private $codFormato;

    /**
     * PK
     * @var integer
     */
    private $codDado;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var integer
     */
    private $codEvento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoInformacao
     */
    private $fkPontoFormatoInformacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras
     */
    private $fkPontoFormatoFaixasHorasExtras;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoExportacao
     */
    private $fkPontoFormatoExportacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\TipoInformacao
     */
    private $fkPontoTipoInformacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    private $fkFolhapagamentoEvento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoFormatoFaixasHorasExtras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return DadosExportacao
     */
    public function setCodFormato($codFormato)
    {
        $this->codFormato = $codFormato;
        return $this;
    }

    /**
     * Get codFormato
     *
     * @return integer
     */
    public function getCodFormato()
    {
        return $this->codFormato;
    }

    /**
     * Set codDado
     *
     * @param integer $codDado
     * @return DadosExportacao
     */
    public function setCodDado($codDado)
    {
        $this->codDado = $codDado;
        return $this;
    }

    /**
     * Get codDado
     *
     * @return integer
     */
    public function getCodDado()
    {
        return $this->codDado;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return DadosExportacao
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
     * Set codEvento
     *
     * @param integer $codEvento
     * @return DadosExportacao
     */
    public function setCodEvento($codEvento)
    {
        $this->codEvento = $codEvento;
        return $this;
    }

    /**
     * Get codEvento
     *
     * @return integer
     */
    public function getCodEvento()
    {
        return $this->codEvento;
    }

    /**
     * OneToMany (owning side)
     * Add PontoFormatoFaixasHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras $fkPontoFormatoFaixasHorasExtras
     * @return DadosExportacao
     */
    public function addFkPontoFormatoFaixasHorasExtras(\Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras $fkPontoFormatoFaixasHorasExtras)
    {
        if (false === $this->fkPontoFormatoFaixasHorasExtras->contains($fkPontoFormatoFaixasHorasExtras)) {
            $fkPontoFormatoFaixasHorasExtras->setFkPontoDadosExportacao($this);
            $this->fkPontoFormatoFaixasHorasExtras->add($fkPontoFormatoFaixasHorasExtras);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoFormatoFaixasHorasExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras $fkPontoFormatoFaixasHorasExtras
     */
    public function removeFkPontoFormatoFaixasHorasExtras(\Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras $fkPontoFormatoFaixasHorasExtras)
    {
        $this->fkPontoFormatoFaixasHorasExtras->removeElement($fkPontoFormatoFaixasHorasExtras);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoFormatoFaixasHorasExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FormatoFaixasHorasExtras
     */
    public function getFkPontoFormatoFaixasHorasExtras()
    {
        return $this->fkPontoFormatoFaixasHorasExtras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoFormatoExportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoExportacao $fkPontoFormatoExportacao
     * @return DadosExportacao
     */
    public function setFkPontoFormatoExportacao(\Urbem\CoreBundle\Entity\Ponto\FormatoExportacao $fkPontoFormatoExportacao)
    {
        $this->codFormato = $fkPontoFormatoExportacao->getCodFormato();
        $this->fkPontoFormatoExportacao = $fkPontoFormatoExportacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoFormatoExportacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FormatoExportacao
     */
    public function getFkPontoFormatoExportacao()
    {
        return $this->fkPontoFormatoExportacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoTipoInformacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\TipoInformacao $fkPontoTipoInformacao
     * @return DadosExportacao
     */
    public function setFkPontoTipoInformacao(\Urbem\CoreBundle\Entity\Ponto\TipoInformacao $fkPontoTipoInformacao)
    {
        $this->codTipo = $fkPontoTipoInformacao->getCodTipo();
        $this->fkPontoTipoInformacao = $fkPontoTipoInformacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoTipoInformacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\TipoInformacao
     */
    public function getFkPontoTipoInformacao()
    {
        return $this->fkPontoTipoInformacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento
     * @return DadosExportacao
     */
    public function setFkFolhapagamentoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\Evento $fkFolhapagamentoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEvento->getCodEvento();
        $this->fkFolhapagamentoEvento = $fkFolhapagamentoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Evento
     */
    public function getFkFolhapagamentoEvento()
    {
        return $this->fkFolhapagamentoEvento;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoFormatoInformacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoInformacao $fkPontoFormatoInformacao
     * @return DadosExportacao
     */
    public function setFkPontoFormatoInformacao(\Urbem\CoreBundle\Entity\Ponto\FormatoInformacao $fkPontoFormatoInformacao)
    {
        $fkPontoFormatoInformacao->setFkPontoDadosExportacao($this);
        $this->fkPontoFormatoInformacao = $fkPontoFormatoInformacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoFormatoInformacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FormatoInformacao
     */
    public function getFkPontoFormatoInformacao()
    {
        return $this->fkPontoFormatoInformacao;
    }
}
