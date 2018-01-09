<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEventoCaso
 */
class ConfiguracaoEventoCaso
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
     * @var integer
     */
    private $codFuncao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var boolean
     */
    private $proporcaoAdiantamento = true;

    /**
     * @var boolean
     */
    private $proporcaoAbono = true;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia
     */
    private $fkFolhapagamentoTipoEventoConfiguracaoMedia;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao
     */
    private $fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo
     */
    private $fkFolhapagamentoConfiguracaoEventoCasoCargos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoBase
     */
    private $fkFolhapagamentoEventoBases;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoBase
     */
    private $fkFolhapagamentoEventoBases1;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento
     */
    private $fkFolhapagamentoEventoConfiguracaoEvento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoConfiguracaoEventoCasoCargos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoEventoBases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoEventoBases1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCaso
     *
     * @param integer $codCaso
     * @return ConfiguracaoEventoCaso
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
     * @return ConfiguracaoEventoCaso
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
     * @return ConfiguracaoEventoCaso
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
     * @return ConfiguracaoEventoCaso
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
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return ConfiguracaoEventoCaso
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ConfiguracaoEventoCaso
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ConfiguracaoEventoCaso
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return ConfiguracaoEventoCaso
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set proporcaoAdiantamento
     *
     * @param boolean $proporcaoAdiantamento
     * @return ConfiguracaoEventoCaso
     */
    public function setProporcaoAdiantamento($proporcaoAdiantamento)
    {
        $this->proporcaoAdiantamento = $proporcaoAdiantamento;
        return $this;
    }

    /**
     * Get proporcaoAdiantamento
     *
     * @return boolean
     */
    public function getProporcaoAdiantamento()
    {
        return $this->proporcaoAdiantamento;
    }

    /**
     * Set proporcaoAbono
     *
     * @param boolean $proporcaoAbono
     * @return ConfiguracaoEventoCaso
     */
    public function setProporcaoAbono($proporcaoAbono)
    {
        $this->proporcaoAbono = $proporcaoAbono;
        return $this;
    }

    /**
     * Get proporcaoAbono
     *
     * @return boolean
     */
    public function getProporcaoAbono()
    {
        return $this->proporcaoAbono;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventoCasoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao
     * @return ConfiguracaoEventoCaso
     */
    public function addFkFolhapagamentoConfiguracaoEventoCasoSubDivisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes->contains($fkFolhapagamentoConfiguracaoEventoCasoSubDivisao)) {
            $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao->setFkFolhapagamentoConfiguracaoEventoCaso($this);
            $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes->add($fkFolhapagamentoConfiguracaoEventoCasoSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoCasoSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao
     */
    public function removeFkFolhapagamentoConfiguracaoEventoCasoSubDivisoes(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao $fkFolhapagamentoConfiguracaoEventoCasoSubDivisao)
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes->removeElement($fkFolhapagamentoConfiguracaoEventoCasoSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoSubDivisao
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasoSubDivisoes()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasoSubDivisoes;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEventoCasoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo
     * @return ConfiguracaoEventoCaso
     */
    public function addFkFolhapagamentoConfiguracaoEventoCasoCargos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEventoCasoCargos->contains($fkFolhapagamentoConfiguracaoEventoCasoCargo)) {
            $fkFolhapagamentoConfiguracaoEventoCasoCargo->setFkFolhapagamentoConfiguracaoEventoCaso($this);
            $this->fkFolhapagamentoConfiguracaoEventoCasoCargos->add($fkFolhapagamentoConfiguracaoEventoCasoCargo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEventoCasoCargo
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo
     */
    public function removeFkFolhapagamentoConfiguracaoEventoCasoCargos(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo $fkFolhapagamentoConfiguracaoEventoCasoCargo)
    {
        $this->fkFolhapagamentoConfiguracaoEventoCasoCargos->removeElement($fkFolhapagamentoConfiguracaoEventoCasoCargo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEventoCasoCargos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEventoCasoCargo
     */
    public function getFkFolhapagamentoConfiguracaoEventoCasoCargos()
    {
        return $this->fkFolhapagamentoConfiguracaoEventoCasoCargos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoBase
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoBase $fkFolhapagamentoEventoBase
     * @return ConfiguracaoEventoCaso
     */
    public function addFkFolhapagamentoEventoBases(\Urbem\CoreBundle\Entity\Folhapagamento\EventoBase $fkFolhapagamentoEventoBase)
    {
        if (false === $this->fkFolhapagamentoEventoBases->contains($fkFolhapagamentoEventoBase)) {
            $fkFolhapagamentoEventoBase->setFkFolhapagamentoConfiguracaoEventoCaso($this);
            $this->fkFolhapagamentoEventoBases->add($fkFolhapagamentoEventoBase);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoBase
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoBase $fkFolhapagamentoEventoBase
     */
    public function removeFkFolhapagamentoEventoBases(\Urbem\CoreBundle\Entity\Folhapagamento\EventoBase $fkFolhapagamentoEventoBase)
    {
        $this->fkFolhapagamentoEventoBases->removeElement($fkFolhapagamentoEventoBase);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoBases
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoBase
     */
    public function getFkFolhapagamentoEventoBases()
    {
        return $this->fkFolhapagamentoEventoBases;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoEventoBase
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoBase $fkFolhapagamentoEventoBase
     * @return ConfiguracaoEventoCaso
     */
    public function addFkFolhapagamentoEventoBases1(\Urbem\CoreBundle\Entity\Folhapagamento\EventoBase $fkFolhapagamentoEventoBase)
    {
        if (false === $this->fkFolhapagamentoEventoBases1->contains($fkFolhapagamentoEventoBase)) {
            $fkFolhapagamentoEventoBase->setFkFolhapagamentoConfiguracaoEventoCaso1($this);
            $this->fkFolhapagamentoEventoBases1->add($fkFolhapagamentoEventoBase);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoEventoBase
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoBase $fkFolhapagamentoEventoBase
     */
    public function removeFkFolhapagamentoEventoBases1(\Urbem\CoreBundle\Entity\Folhapagamento\EventoBase $fkFolhapagamentoEventoBase)
    {
        $this->fkFolhapagamentoEventoBases1->removeElement($fkFolhapagamentoEventoBase);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoEventoBases1
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\EventoBase
     */
    public function getFkFolhapagamentoEventoBases1()
    {
        return $this->fkFolhapagamentoEventoBases1;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoEventoConfiguracaoEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento
     * @return ConfiguracaoEventoCaso
     */
    public function setFkFolhapagamentoEventoConfiguracaoEvento(\Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento $fkFolhapagamentoEventoConfiguracaoEvento)
    {
        $this->codEvento = $fkFolhapagamentoEventoConfiguracaoEvento->getCodEvento();
        $this->timestamp = $fkFolhapagamentoEventoConfiguracaoEvento->getTimestamp();
        $this->codConfiguracao = $fkFolhapagamentoEventoConfiguracaoEvento->getCodConfiguracao();
        $this->fkFolhapagamentoEventoConfiguracaoEvento = $fkFolhapagamentoEventoConfiguracaoEvento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoEventoConfiguracaoEvento
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\EventoConfiguracaoEvento
     */
    public function getFkFolhapagamentoEventoConfiguracaoEvento()
    {
        return $this->fkFolhapagamentoEventoConfiguracaoEvento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return ConfiguracaoEventoCaso
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }

    /**
     * OneToOne (inverse side)
     * Set FolhapagamentoTipoEventoConfiguracaoMedia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia $fkFolhapagamentoTipoEventoConfiguracaoMedia
     * @return ConfiguracaoEventoCaso
     */
    public function setFkFolhapagamentoTipoEventoConfiguracaoMedia(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia $fkFolhapagamentoTipoEventoConfiguracaoMedia)
    {
        $fkFolhapagamentoTipoEventoConfiguracaoMedia->setFkFolhapagamentoConfiguracaoEventoCaso($this);
        $this->fkFolhapagamentoTipoEventoConfiguracaoMedia = $fkFolhapagamentoTipoEventoConfiguracaoMedia;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFolhapagamentoTipoEventoConfiguracaoMedia
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia
     */
    public function getFkFolhapagamentoTipoEventoConfiguracaoMedia()
    {
        return $this->fkFolhapagamentoTipoEventoConfiguracaoMedia;
    }
}
