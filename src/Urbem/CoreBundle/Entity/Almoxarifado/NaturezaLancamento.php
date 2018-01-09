<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * NaturezaLancamento
 */
class NaturezaLancamento
{
    /**
     * PK
     * @var string
     */
    private $exercicioLancamento;

    /**
     * PK
     * @var integer
     */
    private $numLancamento;

    /**
     * PK
     * @var integer
     */
    private $codNatureza;

    /**
     * PK
     * @var string
     */
    private $tipoNatureza;

    /**
     * @var integer
     */
    private $cgmAlmoxarife;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $numcgmUsuario;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    private $fkAlmoxarifadoLancamentoMateriais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor
     */
    private $fkComprasNotaFiscalFornecedores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Natureza
     */
    private $fkAlmoxarifadoNatureza;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife
     */
    private $fkAlmoxarifadoAlmoxarife;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkAlmoxarifadoLancamentoMateriais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkComprasNotaFiscalFornecedores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicioLancamento
     *
     * @param string $exercicioLancamento
     * @return NaturezaLancamento
     */
    public function setExercicioLancamento($exercicioLancamento)
    {
        $this->exercicioLancamento = $exercicioLancamento;
        return $this;
    }

    /**
     * Get exercicioLancamento
     *
     * @return string
     */
    public function getExercicioLancamento()
    {
        return $this->exercicioLancamento;
    }

    /**
     * Set numLancamento
     *
     * @param integer $numLancamento
     * @return NaturezaLancamento
     */
    public function setNumLancamento($numLancamento)
    {
        $this->numLancamento = $numLancamento;
        return $this;
    }

    /**
     * Get numLancamento
     *
     * @return integer
     */
    public function getNumLancamento()
    {
        return $this->numLancamento;
    }

    /**
     * Set codNatureza
     *
     * @param integer $codNatureza
     * @return NaturezaLancamento
     */
    public function setCodNatureza($codNatureza)
    {
        $this->codNatureza = $codNatureza;
        return $this;
    }

    /**
     * Get codNatureza
     *
     * @return integer
     */
    public function getCodNatureza()
    {
        return $this->codNatureza;
    }

    /**
     * Set tipoNatureza
     *
     * @param string $tipoNatureza
     * @return NaturezaLancamento
     */
    public function setTipoNatureza($tipoNatureza)
    {
        $this->tipoNatureza = $tipoNatureza;
        return $this;
    }

    /**
     * Get tipoNatureza
     *
     * @return string
     */
    public function getTipoNatureza()
    {
        return $this->tipoNatureza;
    }

    /**
     * Set cgmAlmoxarife
     *
     * @param integer $cgmAlmoxarife
     * @return NaturezaLancamento
     */
    public function setCgmAlmoxarife($cgmAlmoxarife)
    {
        $this->cgmAlmoxarife = $cgmAlmoxarife;
        return $this;
    }

    /**
     * Get cgmAlmoxarife
     *
     * @return integer
     */
    public function getCgmAlmoxarife()
    {
        return $this->cgmAlmoxarife;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return NaturezaLancamento
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
     * Set numcgmUsuario
     *
     * @param integer $numcgmUsuario
     * @return NaturezaLancamento
     */
    public function setNumcgmUsuario($numcgmUsuario)
    {
        $this->numcgmUsuario = $numcgmUsuario;
        return $this;
    }

    /**
     * Get numcgmUsuario
     *
     * @return integer
     */
    public function getNumcgmUsuario()
    {
        return $this->numcgmUsuario;
    }

    /**
     * OneToMany (owning side)
     * Add AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     * @return NaturezaLancamento
     */
    public function addFkAlmoxarifadoLancamentoMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        if (false === $this->fkAlmoxarifadoLancamentoMateriais->contains($fkAlmoxarifadoLancamentoMaterial)) {
            $fkAlmoxarifadoLancamentoMaterial->setFkAlmoxarifadoNaturezaLancamento($this);
            $this->fkAlmoxarifadoLancamentoMateriais->add($fkAlmoxarifadoLancamentoMaterial);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove AlmoxarifadoLancamentoMaterial
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial
     */
    public function removeFkAlmoxarifadoLancamentoMateriais(\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial $fkAlmoxarifadoLancamentoMaterial)
    {
        $this->fkAlmoxarifadoLancamentoMateriais->removeElement($fkAlmoxarifadoLancamentoMaterial);
    }

    /**
     * OneToMany (owning side)
     * Get fkAlmoxarifadoLancamentoMateriais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial
     */
    public function getFkAlmoxarifadoLancamentoMateriais()
    {
        return $this->fkAlmoxarifadoLancamentoMateriais;
    }

    /**
     * OneToMany (owning side)
     * Add ComprasNotaFiscalFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor
     * @return NaturezaLancamento
     */
    public function addFkComprasNotaFiscalFornecedores(\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor)
    {
        if (false === $this->fkComprasNotaFiscalFornecedores->contains($fkComprasNotaFiscalFornecedor)) {
            $fkComprasNotaFiscalFornecedor->setFkAlmoxarifadoNaturezaLancamento($this);
            $this->fkComprasNotaFiscalFornecedores->add($fkComprasNotaFiscalFornecedor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ComprasNotaFiscalFornecedor
     *
     * @param \Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor
     */
    public function removeFkComprasNotaFiscalFornecedores(\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor $fkComprasNotaFiscalFornecedor)
    {
        $this->fkComprasNotaFiscalFornecedores->removeElement($fkComprasNotaFiscalFornecedor);
    }

    /**
     * OneToMany (owning side)
     * Get fkComprasNotaFiscalFornecedores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Compras\NotaFiscalFornecedor
     */
    public function getFkComprasNotaFiscalFornecedores()
    {
        return $this->fkComprasNotaFiscalFornecedores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoNatureza
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Natureza $fkAlmoxarifadoNatureza
     * @return NaturezaLancamento
     */
    public function setFkAlmoxarifadoNatureza(\Urbem\CoreBundle\Entity\Almoxarifado\Natureza $fkAlmoxarifadoNatureza)
    {
        $this->codNatureza = $fkAlmoxarifadoNatureza->getCodNatureza();
        $this->tipoNatureza = $fkAlmoxarifadoNatureza->getTipoNatureza();
        $this->fkAlmoxarifadoNatureza = $fkAlmoxarifadoNatureza;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoNatureza
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Natureza
     */
    public function getFkAlmoxarifadoNatureza()
    {
        return $this->fkAlmoxarifadoNatureza;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoAlmoxarife
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife $fkAlmoxarifadoAlmoxarife
     * @return NaturezaLancamento
     */
    public function setFkAlmoxarifadoAlmoxarife(\Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife $fkAlmoxarifadoAlmoxarife)
    {
        $this->cgmAlmoxarife = $fkAlmoxarifadoAlmoxarife->getCgmAlmoxarife();
        $this->fkAlmoxarifadoAlmoxarife = $fkAlmoxarifadoAlmoxarife;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoAlmoxarife
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\Almoxarife
     */
    public function getFkAlmoxarifadoAlmoxarife()
    {
        return $this->fkAlmoxarifadoAlmoxarife;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return NaturezaLancamento
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgmUsuario = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return sprintf('Lancamento %s/%s', $this->numLancamento, $this->exercicioLancamento);
    }
}
