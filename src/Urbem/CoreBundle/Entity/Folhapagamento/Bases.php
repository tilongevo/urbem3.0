<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * Bases
 */
class Bases
{
    /**
     * PK
     * @var integer
     */
    private $codBase;

    /**
     * @var string
     */
    private $nomBase;

    /**
     * @var string
     */
    private $tipoBase;

    /**
     * @var boolean
     */
    private $apresentacaoValor;

    /**
     * @var boolean
     */
    private $insercaoAutomatica;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento
     */
    private $fkFolhapagamentoBasesEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado
     */
    private $fkFolhapagamentoBasesEventoCriados;

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
        $this->fkFolhapagamentoBasesEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFolhapagamentoBasesEventoCriados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codBase
     *
     * @param integer $codBase
     * @return Bases
     */
    public function setCodBase($codBase)
    {
        $this->codBase = $codBase;
        return $this;
    }

    /**
     * Get codBase
     *
     * @return integer
     */
    public function getCodBase()
    {
        return $this->codBase;
    }

    /**
     * Set nomBase
     *
     * @param string $nomBase
     * @return Bases
     */
    public function setNomBase($nomBase)
    {
        $this->nomBase = $nomBase;
        return $this;
    }

    /**
     * Get nomBase
     *
     * @return string
     */
    public function getNomBase()
    {
        return $this->nomBase;
    }

    /**
     * Set tipoBase
     *
     * @param string $tipoBase
     * @return Bases
     */
    public function setTipoBase($tipoBase)
    {
        $this->tipoBase = $tipoBase;
        return $this;
    }

    /**
     * Get tipoBase
     *
     * @return string
     */
    public function getTipoBase()
    {
        return $this->tipoBase;
    }

    /**
     * Set apresentacaoValor
     *
     * @param boolean $apresentacaoValor
     * @return Bases
     */
    public function setApresentacaoValor($apresentacaoValor)
    {
        $this->apresentacaoValor = $apresentacaoValor;
        return $this;
    }

    /**
     * Get apresentacaoValor
     *
     * @return boolean
     */
    public function getApresentacaoValor()
    {
        return $this->apresentacaoValor;
    }

    /**
     * Set insercaoAutomatica
     *
     * @param boolean $insercaoAutomatica
     * @return Bases
     */
    public function setInsercaoAutomatica($insercaoAutomatica)
    {
        $this->insercaoAutomatica = $insercaoAutomatica;
        return $this;
    }

    /**
     * Get insercaoAutomatica
     *
     * @return boolean
     */
    public function getInsercaoAutomatica()
    {
        return $this->insercaoAutomatica;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Bases
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
     * @return Bases
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
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return Bases
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
     * OneToMany (owning side)
     * Add FolhapagamentoBasesEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento $fkFolhapagamentoBasesEvento
     * @return Bases
     */
    public function addFkFolhapagamentoBasesEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento $fkFolhapagamentoBasesEvento)
    {
        if (false === $this->fkFolhapagamentoBasesEventos->contains($fkFolhapagamentoBasesEvento)) {
            $fkFolhapagamentoBasesEvento->setFkFolhapagamentoBases($this);
            $this->fkFolhapagamentoBasesEventos->add($fkFolhapagamentoBasesEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoBasesEvento
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento $fkFolhapagamentoBasesEvento
     */
    public function removeFkFolhapagamentoBasesEventos(\Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento $fkFolhapagamentoBasesEvento)
    {
        $this->fkFolhapagamentoBasesEventos->removeElement($fkFolhapagamentoBasesEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoBasesEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BasesEvento
     */
    public function getFkFolhapagamentoBasesEventos()
    {
        return $this->fkFolhapagamentoBasesEventos;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoBasesEventoCriado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado $fkFolhapagamentoBasesEventoCriado
     * @return Bases
     */
    public function addFkFolhapagamentoBasesEventoCriados(\Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado $fkFolhapagamentoBasesEventoCriado)
    {
        if (false === $this->fkFolhapagamentoBasesEventoCriados->contains($fkFolhapagamentoBasesEventoCriado)) {
            $fkFolhapagamentoBasesEventoCriado->setFkFolhapagamentoBases($this);
            $this->fkFolhapagamentoBasesEventoCriados->add($fkFolhapagamentoBasesEventoCriado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoBasesEventoCriado
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado $fkFolhapagamentoBasesEventoCriado
     */
    public function removeFkFolhapagamentoBasesEventoCriados(\Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado $fkFolhapagamentoBasesEventoCriado)
    {
        $this->fkFolhapagamentoBasesEventoCriados->removeElement($fkFolhapagamentoBasesEventoCriado);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoBasesEventoCriados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\BasesEventoCriado
     */
    public function getFkFolhapagamentoBasesEventoCriados()
    {
        return $this->fkFolhapagamentoBasesEventoCriados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return Bases
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
     * retorn o cod da base como representação da entidade
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getCodBase();
    }
}
