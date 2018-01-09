<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * ConfiguracaoEmpenhoAtributo
 */
class ConfiguracaoEmpenhoAtributo
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

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
     * @var integer
     */
    private $sequencia;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor
     */
    private $fkFolhapagamentoConfiguracaoEmpenhoAtributoValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    private $fkFolhapagamentoConfiguracaoEmpenho;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico
     */
    private $fkAdministracaoAtributoDinamico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoAtributoValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoEmpenhoAtributo
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoEmpenhoAtributo
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
     * Set codAtributo
     *
     * @param integer $codAtributo
     * @return ConfiguracaoEmpenhoAtributo
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
     * @return ConfiguracaoEmpenhoAtributo
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
     * @return ConfiguracaoEmpenhoAtributo
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
     * Set sequencia
     *
     * @param integer $sequencia
     * @return ConfiguracaoEmpenhoAtributo
     */
    public function setSequencia($sequencia)
    {
        $this->sequencia = $sequencia;
        return $this;
    }

    /**
     * Get sequencia
     *
     * @return integer
     */
    public function getSequencia()
    {
        return $this->sequencia;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ConfiguracaoEmpenhoAtributo
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
     * Add FolhapagamentoConfiguracaoEmpenhoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoAtributoValor
     * @return ConfiguracaoEmpenhoAtributo
     */
    public function addFkFolhapagamentoConfiguracaoEmpenhoAtributoValores(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoAtributoValor)
    {
        if (false === $this->fkFolhapagamentoConfiguracaoEmpenhoAtributoValores->contains($fkFolhapagamentoConfiguracaoEmpenhoAtributoValor)) {
            $fkFolhapagamentoConfiguracaoEmpenhoAtributoValor->setFkFolhapagamentoConfiguracaoEmpenhoAtributo($this);
            $this->fkFolhapagamentoConfiguracaoEmpenhoAtributoValores->add($fkFolhapagamentoConfiguracaoEmpenhoAtributoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoConfiguracaoEmpenhoAtributoValor
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoAtributoValor
     */
    public function removeFkFolhapagamentoConfiguracaoEmpenhoAtributoValores(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor $fkFolhapagamentoConfiguracaoEmpenhoAtributoValor)
    {
        $this->fkFolhapagamentoConfiguracaoEmpenhoAtributoValores->removeElement($fkFolhapagamentoConfiguracaoEmpenhoAtributoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoConfiguracaoEmpenhoAtributoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenhoAtributoValor
     */
    public function getFkFolhapagamentoConfiguracaoEmpenhoAtributoValores()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenhoAtributoValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFolhapagamentoConfiguracaoEmpenho
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho
     * @return ConfiguracaoEmpenhoAtributo
     */
    public function setFkFolhapagamentoConfiguracaoEmpenho(\Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho $fkFolhapagamentoConfiguracaoEmpenho)
    {
        $this->codConfiguracao = $fkFolhapagamentoConfiguracaoEmpenho->getCodConfiguracao();
        $this->exercicio = $fkFolhapagamentoConfiguracaoEmpenho->getExercicio();
        $this->sequencia = $fkFolhapagamentoConfiguracaoEmpenho->getSequencia();
        $this->timestamp = $fkFolhapagamentoConfiguracaoEmpenho->getTimestamp();
        $this->fkFolhapagamentoConfiguracaoEmpenho = $fkFolhapagamentoConfiguracaoEmpenho;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFolhapagamentoConfiguracaoEmpenho
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEmpenho
     */
    public function getFkFolhapagamentoConfiguracaoEmpenho()
    {
        return $this->fkFolhapagamentoConfiguracaoEmpenho;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAtributoDinamico
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\AtributoDinamico $fkAdministracaoAtributoDinamico
     * @return ConfiguracaoEmpenhoAtributo
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
}
