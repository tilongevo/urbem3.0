<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoLlaAtributo
 */
class ConfiguracaoEmpenhoLlaAtributo
{
    /**
     * PK
     * @var integer
     */
    private $codAtributo;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codCadastro;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracaoLla;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoLla;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return ConfiguracaoEmpenhoLlaAtributo
     */
    public function setCodAtributo($codAtributo)
    {
        $this->codAtributo = $codAtributo;
        return $this;
    }

    /**
     * Get codAtributo
     *
     * @return integer
     */
    public function getCodAtributo()
    {
        return $this->codAtributo;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return ConfiguracaoEmpenhoLlaAtributo
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
     * Set codCadastro
     *
     * @param integer $codCadastro
     * @return ConfiguracaoEmpenhoLlaAtributo
     */
    public function setCodCadastro($codCadastro)
    {
        $this->codCadastro = $codCadastro;
        return $this;
    }

    /**
     * Get codCadastro
     *
     * @return integer
     */
    public function getCodCadastro()
    {
        return $this->codCadastro;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoLlaAtributo
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
     * Set codConfiguracaoLla
     *
     * @param integer $codConfiguracaoLla
     * @return ConfiguracaoEmpenhoLlaAtributo
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ConfiguracaoEmpenhoLlaAtributo
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoConfiguracaoEmpenhoLlaAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor
     * @return ConfiguracaoEmpenhoLlaAtributo
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores->contains($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor)) {
            $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor->setFkFolhapagamentoConfiguracaoEmpenhoLlaAtributo($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores->add($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoLlaAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores->removeElement($fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLlaAtributoValor
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLlaAtributoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return ConfiguracaoEmpenhoLlaAtributo
     */
    public function setFkAdministracaoAtributoDinamico(\Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico)
    {
        $this->codModulo = $fkAdministracaoAtributoDinamico->getCodModulo();
        $this->codCadastro = $fkAdministracaoAtributoDinamico->getCodCadastro();
        $this->codAtributo = $fkAdministracaoAtributoDinamico->getCodAtributo();
        $this->fkAdministracaoAtributoDinamico = $fkAdministracaoAtributoDinamico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAtributoDinamico
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    public function getFkAdministracaoAtributoDinamico()
    {
        return $this->fkAdministracaoAtributoDinamico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEmpenhoLla
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla $fkFolhapagamentoConfiguracaoEmpenhoLla
     * @return ConfiguracaoEmpenhoLlaAtributo
     */
    public function setFkFolhapagamentoConfiguracaoEmpenhoLla(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla $fkFolhapagamentoConfiguracaoEmpenhoLla)
    {
        $this->codConfiguracaoLla = $fkFolhapagamentoConfiguracaoEmpenhoLla->getCodConfiguracaoLla();
        $this->exercicio = $fkFolhapagamentoConfiguracaoEmpenhoLla->getExercicio();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEmpenhoLla->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoEmpenhoLla = $fkFolhapagamentoConfiguracaoEmpenhoLla;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoLla
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoLla
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoLla()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoLla;
    }
}
