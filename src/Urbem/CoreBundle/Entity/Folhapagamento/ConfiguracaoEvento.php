<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEvento
 */
class ConfiguracaoEvento
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento
     */
    private $fkFolhapagamentoEventoConfiguracaoEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar
     */
    private $fkFolhapagamentoRegistroEventoComplementares;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoDesdobramento
     */
    private $fkFolhapagamentoConfiguracaoDesdobramentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoEmpenhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoEventoConfiguracaoEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoRegistroEventoComplementares = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoDesdobramentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEmpenhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEvento
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
     * Set descricao
     *
     * @param string $descricao
     * @return ConfiguracaoEvento
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
     * Add FolhapagamentoEventoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento
     * @return ConfiguracaoEvento
     */
    public function addFkFolhapagamentoEventoConfiguracaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento)
    {
        if (false === $this->fkFolhapagamentoEventoConfiguracaoEventos->contains($fkFolhapagamentoEventoConfiguracaoEvento)) {
            $fkFolhapagamentoEventoConfiguracaoEvento->setFkFolhapagamentoConfiguracaoEvento($this);
            $this->fkFolhapagamentoEventoConfiguracaoEventos->add($fkFolhapagamentoEventoConfiguracaoEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento
     */
    public function removeFkFolhapagamentoEventoConfiguracaoEventos(\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento)
    {
        $this->fkFolhapagamentoEventoConfiguracaoEventos->removeElement($fkFolhapagamentoEventoConfiguracaoEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoConfiguracaoEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento
     */
    public function getFkFolhapagamentoEventoConfiguracaoEventos()
    {
        return $this->fkFolhapagamentoEventoConfiguracaoEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar
     * @return ConfiguracaoEvento
     */
    public function addFkFolhapagamentoRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar)
    {
        if (false === $this->fkFolhapagamentoRegistroEventoComplementares->contains($fkFolhapagamentoRegistroEventoComplementar)) {
            $fkFolhapagamentoRegistroEventoComplementar->setFkFolhapagamentoConfiguracaoEvento($this);
            $this->fkFolhapagamentoRegistroEventoComplementares->add($fkFolhapagamentoRegistroEventoComplementar);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoRegistroEventoComplementar
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar
     */
    public function removeFkFolhapagamentoRegistroEventoComplementares(\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar $fkFolhapagamentoRegistroEventoComplementar)
    {
        $this->fkFolhapagamentoRegistroEventoComplementares->removeElement($fkFolhapagamentoRegistroEventoComplementar);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoRegistroEventoComplementares
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar
     */
    public function getFkFolhapagamentoRegistroEventoComplementares()
    {
        return $this->fkFolhapagamentoRegistroEventoComplementares;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoDesdobramento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoDesdobramento $fkFolhapagamentoConfiguracaoDesdobramento
     * @return ConfiguracaoEvento
     */
    public function addFkFolhapagamentoConfiguracaoDesdobramentos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoDesdobramento $fkFolhapagamentoConfiguracaoDesdobramento)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoDesdobramentos->contains($fkFolhapagamentoConfiguracaoDesdobramento)) {
            $fkFolhapagamentoConfiguracaoDesdobramento->setFkFolhapagamentoConfiguracaoEvento($this);
            $this->fkFolhapagamentoConfiguracaoDesdobramentos->add($fkFolhapagamentoConfiguracaoDesdobramento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoDesdobramento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoDesdobramento $fkFolhapagamentoConfiguracaoDesdobramento
     */
    public function removeFkFolhapagamentoConfiguracaoDesdobramentos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoDesdobramento $fkFolhapagamentoConfiguracaoDesdobramento)
    {
        $this->fkFolhapagamentoConfiguracaoDesdobramentos->removeElement($fkFolhapagamentoConfiguracaoDesdobramento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoDesdobramentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoDesdobramento
     */
    public function getFkFolhapagamentoConfiguracaoDesdobramentos()
    {
        return $this->fkFolhapagamentoConfiguracaoDesdobramentos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     * @return ConfiguracaoEvento
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhos->contains($fkFolhapagamentoConfiguracaoEmpenho)) {
            $fkFolhapagamentoConfiguracaoEmpenho->setFkFolhapagamentoConfiguracaoEvento($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhos->add($fkFolhapagamentoConfiguracaoEmpenho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhos->removeElement($fkFolhapagamentoConfiguracaoEmpenho);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhos()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhos;
    }
}
