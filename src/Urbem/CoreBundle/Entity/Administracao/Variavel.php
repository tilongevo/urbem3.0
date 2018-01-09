<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * Variavel
 */
class Variavel
{
    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codBiblioteca;

    /**
     * PK
     * @var integer
     */
    private $codFuncao;

    /**
     * PK
     * @var integer
     */
    private $codVariavel;

    /**
     * @var string
     */
    private $nomVariavel;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $valorInicial;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Parametro
     */
    private $fkAdministracaoParametros;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo
     */
    private $fkAdministracaoTipoPrimitivo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAdministracaoParametros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return Variavel
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
     * @return Variavel
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
     * @return Variavel
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
     * Set codVariavel
     *
     * @param integer $codVariavel
     * @return Variavel
     */
    public function setCodVariavel($codVariavel)
    {
        $this->codVariavel = $codVariavel;
        return $this;
    }

    /**
     * Get codVariavel
     *
     * @return integer
     */
    public function getCodVariavel()
    {
        return $this->codVariavel;
    }

    /**
     * Set nomVariavel
     *
     * @param string $nomVariavel
     * @return Variavel
     */
    public function setNomVariavel($nomVariavel = null)
    {
        $this->nomVariavel = $nomVariavel;
        return $this;
    }

    /**
     * Get nomVariavel
     *
     * @return string
     */
    public function getNomVariavel()
    {
        return $this->nomVariavel;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Variavel
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
     * Set valorInicial
     *
     * @param string $valorInicial
     * @return Variavel
     */
    public function setValorInicial($valorInicial = null)
    {
        $this->valorInicial = $valorInicial;
        return $this;
    }

    /**
     * Get valorInicial
     *
     * @return string
     */
    public function getValorInicial()
    {
        return $this->valorInicial;
    }

    /**
     * OneToMany (owning side)
     * Add AdministracaoParametro
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Parametro $fkAdministracaoParametro
     * @return Variavel
     */
    public function addFkAdministracaoParametros(\Urbem\CoreBundle\Entity\Administracao\Parametro $fkAdministracaoParametro)
    {
        if (false === $this->fkAdministracaoParametros->contains($fkAdministracaoParametro)) {
            $fkAdministracaoParametro->setFkAdministracaoVariavel($this);
            $this->fkAdministracaoParametros->add($fkAdministracaoParametro);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AdministracaoParametro
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Parametro $fkAdministracaoParametro
     */
    public function removeFkAdministracaoParametros(\Urbem\CoreBundle\Entity\Administracao\Parametro $fkAdministracaoParametro)
    {
        $this->fkAdministracaoParametros->removeElement($fkAdministracaoParametro);
    }

    /**
     * OneToMany (owning side)
     * Get fkAdministracaoParametros
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Administracao\Parametro
     */
    public function getFkAdministracaoParametros()
    {
        return $this->fkAdministracaoParametros;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return Variavel
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoTipoPrimitivo
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo $fkAdministracaoTipoPrimitivo
     * @return Variavel
     */
    public function setFkAdministracaoTipoPrimitivo(\Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo $fkAdministracaoTipoPrimitivo)
    {
        $this->codTipo = $fkAdministracaoTipoPrimitivo->getCodTipo();
        $this->fkAdministracaoTipoPrimitivo = $fkAdministracaoTipoPrimitivo;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoTipoPrimitivo
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\TipoPrimitivo
     */
    public function getFkAdministracaoTipoPrimitivo()
    {
        return $this->fkAdministracaoTipoPrimitivo;
    }
}
