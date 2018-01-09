<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * FormatoExportacao
 */
class FormatoExportacao
{
    /**
     * PK
     * @var integer
     */
    private $codFormato;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $formatoMinutos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DadosExportacao
     */
    private $fkPontoDadosExportacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoDadosExportacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return FormatoExportacao
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
     * Set descricao
     *
     * @param string $descricao
     * @return FormatoExportacao
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
     * Set formatoMinutos
     *
     * @param string $formatoMinutos
     * @return FormatoExportacao
     */
    public function setFormatoMinutos($formatoMinutos)
    {
        $this->formatoMinutos = $formatoMinutos;
        return $this;
    }

    /**
     * Get formatoMinutos
     *
     * @return string
     */
    public function getFormatoMinutos()
    {
        return $this->formatoMinutos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoDadosExportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao
     * @return FormatoExportacao
     */
    public function addFkPontoDadosExportacoes(\Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao)
    {
        if (false === $this->fkPontoDadosExportacoes->contains($fkPontoDadosExportacao)) {
            $fkPontoDadosExportacao->setFkPontoFormatoExportacao($this);
            $this->fkPontoDadosExportacoes->add($fkPontoDadosExportacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoDadosExportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao
     */
    public function removeFkPontoDadosExportacoes(\Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao)
    {
        $this->fkPontoDadosExportacoes->removeElement($fkPontoDadosExportacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoDadosExportacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\DadosExportacao
     */
    public function getFkPontoDadosExportacoes()
    {
        return $this->fkPontoDadosExportacoes;
    }
}
