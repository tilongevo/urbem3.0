<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoLla
 */
class ConfiguracaoEmpenhoLla
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoLla;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var \DateTime
     */
    private $vigencia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaLocais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codConfiguracaoLla
     *
     * @param integer $codConfiguracaoLla
     * @return ConfiguracaoEmpenhoLla
     */
    public function setCodConfiguracaoLla($codConfiguracaoLla)
    {
        $this->codConfiguracaoLla = $codConfiguracaoLla;
        return $this;
    }

    /**
     * Get codConfiguracaoLla
     *
     * @return integer
     */
    public function getCodConfiguracaoLla()
    {
        return $this->codConfiguracaoLla;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoLla
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEmpenhoLla
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set vigencia
     *
     * @param \DateTime $vigencia
     * @return ConfiguracaoEmpenhoLla
     */
    public function setVigencia(\DateTime $vigencia)
    {
        $this->vigencia = $vigencia;
        return $this;
    }

    /**
     * Get vigencia
     *
     * @return \DateTime
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo
     * @return ConfiguracaoEmpenhoLla
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaAtributos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo->setFkFolhapagamentoConfiguracaoEmpenhoLla($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos->add($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaAtributo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaAtributos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributo
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaAtributos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal
     * @return ConfiguracaoEmpenhoLla
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal->setFkFolhapagamentoConfiguracaoEmpenhoLla($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->add($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaLocais(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal $fkFolhapagamentoConfiguracaoEmpenhoLlaLocal)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaLocal);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaLocais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLocal
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaLocais()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLocais;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao
     * @return ConfiguracaoEmpenhoLla
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao->setFkFolhapagamentoConfiguracaoEmpenhoLla($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->add($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaLotacao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao $fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaLotacao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaLotacao
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaLotacoes;
    }
}
