<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FormatoDelimitador
 */
class FormatoDelimitador
{
    /**
     * PK
     * @var integer
     */
    private $codFormato;

    /**
     * @var string
     */
    private $formatoDelimitador;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao
     */
    private $fkPontoFormatoImportacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas
     */
    private $fkPontoDelimitadorColunas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoDelimitadorColunas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return FormatoDelimitador
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
     * Set formatoDelimitador
     *
     * @param string $formatoDelimitador
     * @return FormatoDelimitador
     */
    public function setFormatoDelimitador($formatoDelimitador)
    {
        $this->formatoDelimitador = $formatoDelimitador;
        return $this;
    }

    /**
     * Get formatoDelimitador
     *
     * @return string
     */
    public function getFormatoDelimitador()
    {
        return $this->formatoDelimitador;
    }

    /**
     * OneToMany (owning side)
     * Add PontoDelimitadorColunas
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas $fkPontoDelimitadorColunas
     * @return FormatoDelimitador
     */
    public function addFkPontoDelimitadorColunas(\Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas $fkPontoDelimitadorColunas)
    {
        if (false === $this->fkPontoDelimitadorColunas->contains($fkPontoDelimitadorColunas)) {
            $fkPontoDelimitadorColunas->setFkPontoFormatoDelimitador($this);
            $this->fkPontoDelimitadorColunas->add($fkPontoDelimitadorColunas);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoDelimitadorColunas
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas $fkPontoDelimitadorColunas
     */
    public function removeFkPontoDelimitadorColunas(\Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas $fkPontoDelimitadorColunas)
    {
        $this->fkPontoDelimitadorColunas->removeElement($fkPontoDelimitadorColunas);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoDelimitadorColunas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DelimitadorColunas
     */
    public function getFkPontoDelimitadorColunas()
    {
        return $this->fkPontoDelimitadorColunas;
    }

    /**
     * OneToOne (owning side)
     * Set PontoFormatoImportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao $fkPontoFormatoImportacao
     * @return FormatoDelimitador
     */
    public function setFkPontoFormatoImportacao(\Urbem\CoreBundle\Entity\Ponto\FormatoImportacao $fkPontoFormatoImportacao)
    {
        $this->codFormato = $fkPontoFormatoImportacao->getCodFormato();
        $this->fkPontoFormatoImportacao = $fkPontoFormatoImportacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkPontoFormatoImportacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao
     */
    public function getFkPontoFormatoImportacao()
    {
        return $this->fkPontoFormatoImportacao;
    }
}
