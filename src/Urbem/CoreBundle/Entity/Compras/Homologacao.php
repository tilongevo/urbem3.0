<?php
 
namespace Urbem\CoreBundle\Entity\Compras;

/**
 * Homologacao
 */
class Homologacao
{
    /**
     * PK
     * @var integer
     */
    private $numHomologacao;

    /**
     * PK
     * @var string
     */
    private $exercicioCompraDireta;

    /**
     * PK
     * @var integer
     */
    private $codCompraDireta;

    /**
     * PK
     * @var integer
     */
    private $codModalidade;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $lote;

    /**
     * PK
     * @var integer
     */
    private $codCotacao;

    /**
     * PK
     * @var integer
     */
    private $codItem;

    /**
     * PK
     * @var string
     */
    private $exercicioCotacao;

    /**
     * PK
     * @var integer
     */
    private $cgmFornecedor;

    /**
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * @var boolean
     */
    private $homologado;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\JulgamentoItem
     */
    private $fkComprasJulgamentoItem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Compras\CompraDireta
     */
    private $fkComprasCompraDireta;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \DateTime;
    }

    /**
     * Set numHomologacao
     *
     * @param integer $numHomologacao
     * @return Homologacao
     */
    public function setNumHomologacao($numHomologacao)
    {
        $this->numHomologacao = $numHomologacao;
        return $this;
    }

    /**
     * Get numHomologacao
     *
     * @return integer
     */
    public function getNumHomologacao()
    {
        return $this->numHomologacao;
    }

    /**
     * Set exercicioCompraDireta
     *
     * @param string $exercicioCompraDireta
     * @return Homologacao
     */
    public function setExercicioCompraDireta($exercicioCompraDireta)
    {
        $this->exercicioCompraDireta = $exercicioCompraDireta;
        return $this;
    }

    /**
     * Get exercicioCompraDireta
     *
     * @return string
     */
    public function getExercicioCompraDireta()
    {
        return $this->exercicioCompraDireta;
    }

    /**
     * Set codCompraDireta
     *
     * @param integer $codCompraDireta
     * @return Homologacao
     */
    public function setCodCompraDireta($codCompraDireta)
    {
        $this->codCompraDireta = $codCompraDireta;
        return $this;
    }

    /**
     * Get codCompraDireta
     *
     * @return integer
     */
    public function getCodCompraDireta()
    {
        return $this->codCompraDireta;
    }

    /**
     * Set codModalidade
     *
     * @param integer $codModalidade
     * @return Homologacao
     */
    public function setCodModalidade($codModalidade)
    {
        $this->codModalidade = $codModalidade;
        return $this;
    }

    /**
     * Get codModalidade
     *
     * @return integer
     */
    public function getCodModalidade()
    {
        return $this->codModalidade;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Homologacao
     */
    public function setCodEntidade($codEntidade)
    {
        $this->codEntidade = $codEntidade;
        return $this;
    }

    /**
     * Get codEntidade
     *
     * @return integer
     */
    public function getCodEntidade()
    {
        return $this->codEntidade;
    }

    /**
     * Set lote
     *
     * @param integer $lote
     * @return Homologacao
     */
    public function setLote($lote)
    {
        $this->lote = $lote;
        return $this;
    }

    /**
     * Get lote
     *
     * @return integer
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set codCotacao
     *
     * @param integer $codCotacao
     * @return Homologacao
     */
    public function setCodCotacao($codCotacao)
    {
        $this->codCotacao = $codCotacao;
        return $this;
    }

    /**
     * Get codCotacao
     *
     * @return integer
     */
    public function getCodCotacao()
    {
        return $this->codCotacao;
    }

    /**
     * Set codItem
     *
     * @param integer $codItem
     * @return Homologacao
     */
    public function setCodItem($codItem)
    {
        $this->codItem = $codItem;
        return $this;
    }

    /**
     * Get codItem
     *
     * @return integer
     */
    public function getCodItem()
    {
        return $this->codItem;
    }

    /**
     * Set exercicioCotacao
     *
     * @param string $exercicioCotacao
     * @return Homologacao
     */
    public function setExercicioCotacao($exercicioCotacao)
    {
        $this->exercicioCotacao = $exercicioCotacao;
        return $this;
    }

    /**
     * Get exercicioCotacao
     *
     * @return string
     */
    public function getExercicioCotacao()
    {
        return $this->exercicioCotacao;
    }

    /**
     * Set cgmFornecedor
     *
     * @param integer $cgmFornecedor
     * @return Homologacao
     */
    public function setCgmFornecedor($cgmFornecedor)
    {
        $this->cgmFornecedor = $cgmFornecedor;
        return $this;
    }

    /**
     * Get cgmFornecedor
     *
     * @return integer
     */
    public function getCgmFornecedor()
    {
        return $this->cgmFornecedor;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Homologacao
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
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return Homologacao
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return Homologacao
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * Set homologado
     *
     * @param boolean $homologado
     * @return Homologacao
     */
    public function setHomologado($homologado)
    {
        $this->homologado = $homologado;
        return $this;
    }

    /**
     * Get homologado
     *
     * @return boolean
     */
    public function getHomologado()
    {
        return $this->homologado;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Homologacao
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkComprasJulgamentoItem
     *
     * @param \Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem
     * @return Homologacao
     */
    public function setFkComprasJulgamentoItem(\Urbem\CoreBundle\Entity\Compras\JulgamentoItem $fkComprasJulgamentoItem)
    {
        $this->exercicioCotacao = $fkComprasJulgamentoItem->getExercicio();
        $this->codCotacao = $fkComprasJulgamentoItem->getCodCotacao();
        $this->codItem = $fkComprasJulgamentoItem->getCodItem();
        $this->cgmFornecedor = $fkComprasJulgamentoItem->getCgmFornecedor();
        $this->lote = $fkComprasJulgamentoItem->getLote();
        $this->fkComprasJulgamentoItem = $fkComprasJulgamentoItem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkComprasJulgamentoItem
     *
     * @return \Urbem\CoreBundle\Entity\Compras\JulgamentoItem
     */
    public function getFkComprasJulgamentoItem()
    {
        return $this->fkComprasJulgamentoItem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return Homologacao
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }

    /**
     * Set fkComprasCompraDireta
     *
     * @param \Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta
     * @return $this
     */
    public function setFkComprasCompraDireta(\Urbem\CoreBundle\Entity\Compras\CompraDireta $fkComprasCompraDireta)
    {
        $this->codCompraDireta = $fkComprasCompraDireta->getCodCompraDireta();
        $this->codEntidade = $fkComprasCompraDireta->getCodEntidade();
        $this->exercicioCompraDireta = $fkComprasCompraDireta->getExercicioEntidade();
        $this->codModalidade = $fkComprasCompraDireta->getCodModalidade();
        $this->fkComprasCompraDireta = $fkComprasCompraDireta;
        return $this;
    }

    /**
     * @return CompraDireta
     */
    public function getFkComprasCompraDireta()
    {
        return $this->fkComprasCompraDireta;
    }
}
