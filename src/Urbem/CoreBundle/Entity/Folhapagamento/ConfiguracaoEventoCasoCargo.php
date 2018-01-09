<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEventoCasoCargo
 */
class ConfiguracaoEventoCasoCargo
{
    /**
     * PK
     * @var integer
     */
    private $codCaso;

    /**
     * PK
     * @var integer
     */
    private $codEvento;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var integer
     */
    private $codCargo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade
     */
    private $fkFolhapagamentoConfiguracaoEventoCasoEspecialidades;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    private $fkFolhapagamentoConfiguracaoEventoCaso;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    private $fkPessoalCargo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCaso
     *
     * @param integer $codCaso
     * @return ConfiguracaoEventoCasoCargo
     */
    public function setCodCaso($codCaso)
    {
        $this->codCaso = $codCaso;
        return $this;
    }

    /**
     * Get codCaso
     *
     * @return integer
     */
    public function getCodCaso()
    {
        return $this->codCaso;
    }

    /**
     * Set codEvento
     *
     * @param integer $codEvento
     * @return ConfiguracaoEventoCasoCargo
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ConfiguracaoEventoCasoCargo
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
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEventoCasoCargo
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set codCargo
     *
     * @param integer $codCargo
     * @return ConfiguracaoEventoCasoCargo
     */
    public function setCodCargo($codCargo)
    {
        $this->codCargo = $codCargo;
        return $this;
    }

    /**
     * Get codCargo
     *
     * @return integer
     */
    public function getCodCargo()
    {
        return $this->codCargo;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventoCasoEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade
     * @return ConfiguracaoEventoCasoCargo
     */
    public function addFkFolhapagamentoConfiguracaoEventoCasoEspecialidades(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades->contains($fkFolhapagamentoConfiguracaoEventoCasoEspecialidade)) {
            $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade->setFkFolhapagamentoConfiguracaoEventoCasoCargo($this);
            $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades->add($fkFolhapagamentoConfiguracaoEventoCasoEspecialidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoCasoEspecialidade
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade
     */
    public function removeFkFolhapagamentoConfiguracaoEventoCasoEspecialidades(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade $fkFolhapagamentoConfiguracaoEventoCasoEspecialidade)
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades->removeElement($fkFolhapagamentoConfiguracaoEventoCasoEspecialidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCasoEspecialidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoEspecialidade
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasoEspecialidades()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasoEspecialidades;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEventoCaso
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso
     * @return ConfiguracaoEventoCasoCargo
     */
    public function setFkFolhapagamentoConfiguracaoEventoCaso(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso $fkFolhapagamentoConfiguracaoEventoCaso)
    {
        $this->codCaso = $fkFolhapagamentoConfiguracaoEventoCaso->getCodCaso();
        $this->codEvento = $fkFolhapagamentoConfiguracaoEventoCaso->getCodEvento();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEventoCaso->getTimestamp();
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEventoCaso->getCodConfiguracao();
        $this->fkFolhapagamentoConfiguracaoEventoCaso = $fkFolhapagamentoConfiguracaoEventoCaso;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEventoCaso
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCaso
     */
    public function getFkFolhapagamentoConfiguracaoEventoCaso()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCaso;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalCargo
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo
     * @return ConfiguracaoEventoCasoCargo
     */
    public function setFkPessoalCargo(\Urbem\CoreBundle\Entity\Pessoal\Cargo $fkPessoalCargo)
    {
        $this->codCargo = $fkPessoalCargo->getCodCargo();
        $this->fkPessoalCargo = $fkPessoalCargo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalCargo
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Cargo
     */
    public function getFkPessoalCargo()
    {
        return $this->fkPessoalCargo;
    }
}
