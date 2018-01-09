<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * TipoInformacao
 */
class TipoInformacao
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto
     */
    private $fkPontoExportacaoPontos;

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
        $this->fkPontoExportacaoPontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoDadosExportacoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoInformacao
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
     * @return TipoInformacao
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
     * Add PontoExportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto
     * @return TipoInformacao
     */
    public function addFkPontoExportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto)
    {
        if (false === $this->fkPontoExportacaoPontos->contains($fkPontoExportacaoPonto)) {
            $fkPontoExportacaoPonto->setFkPontoTipoInformacao($this);
            $this->fkPontoExportacaoPontos->add($fkPontoExportacaoPonto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoExportacaoPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto
     */
    public function removeFkPontoExportacaoPontos(\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto $fkPontoExportacaoPonto)
    {
        $this->fkPontoExportacaoPontos->removeElement($fkPontoExportacaoPonto);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoExportacaoPontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ExportacaoPonto
     */
    public function getFkPontoExportacaoPontos()
    {
        return $this->fkPontoExportacaoPontos;
    }

    /**
     * OneToMany (owning side)
     * Add PontoDadosExportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao
     * @return TipoInformacao
     */
    public function addFkPontoDadosExportacoes(\Urbem\CoreBundle\Entity\Ponto\DadosExportacao $fkPontoDadosExportacao)
    {
        if (false === $this->fkPontoDadosExportacoes->contains($fkPontoDadosExportacao)) {
            $fkPontoDadosExportacao->setFkPontoTipoInformacao($this);
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
