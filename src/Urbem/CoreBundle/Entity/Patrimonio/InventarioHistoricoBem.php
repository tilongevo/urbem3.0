<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * InventarioHistoricoBem
 */
class InventarioHistoricoBem
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $idInventario;

    /**
     * PK
     * @var integer
     */
    private $codBem;

    /**
     * @var \DateTime
     */
    private $timestampHistorico;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codSituacao;

    /**
     * @var integer
     */
    private $codLocal;

    /**
     * @var integer
     */
    private $codOrgao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Inventario
     */
    private $fkPatrimonioInventario;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    private $fkPatrimonioHistoricoBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    private $fkPatrimonioBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem
     */
    private $fkPatrimonioSituacaoBem;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return InventarioHistoricoBem
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
     * Set idInventario
     *
     * @param integer $idInventario
     * @return InventarioHistoricoBem
     */
    public function setIdInventario($idInventario)
    {
        $this->idInventario = $idInventario;
        return $this;
    }

    /**
     * Get idInventario
     *
     * @return integer
     */
    public function getIdInventario()
    {
        return $this->idInventario;
    }

    /**
     * Set codBem
     *
     * @param integer $codBem
     * @return InventarioHistoricoBem
     */
    public function setCodBem($codBem)
    {
        $this->codBem = $codBem;
        return $this;
    }

    /**
     * Get codBem
     *
     * @return integer
     */
    public function getCodBem()
    {
        return $this->codBem;
    }

    /**
     * Set timestampHistorico
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampHistorico
     * @return InventarioHistoricoBem
     */
    public function setTimestampHistorico(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestampHistorico)
    {
        $this->timestampHistorico = $timestampHistorico;
        return $this;
    }

    /**
     * Get timestampHistorico
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestampHistorico()
    {
        return $this->timestampHistorico;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return InventarioHistoricoBem
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
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return InventarioHistoricoBem
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set codLocal
     *
     * @param integer $codLocal
     * @return InventarioHistoricoBem
     */
    public function setCodLocal($codLocal)
    {
        $this->codLocal = $codLocal;
        return $this;
    }

    /**
     * Get codLocal
     *
     * @return integer
     */
    public function getCodLocal()
    {
        return $this->codLocal;
    }

    /**
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return InventarioHistoricoBem
     */
    public function setCodOrgao($codOrgao)
    {
        $this->codOrgao = $codOrgao;
        return $this;
    }

    /**
     * Get codOrgao
     *
     * @return integer
     */
    public function getCodOrgao()
    {
        return $this->codOrgao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return InventarioHistoricoBem
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
     * ManyToOne (inverse side)
     * Set fkPatrimonioInventario
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Inventario $fkPatrimonioInventario
     * @return InventarioHistoricoBem
     */
    public function setFkPatrimonioInventario(\Urbem\CoreBundle\Entity\Patrimonio\Inventario $fkPatrimonioInventario)
    {
        $this->exercicio = $fkPatrimonioInventario->getExercicio();
        $this->idInventario = $fkPatrimonioInventario->getIdInventario();
        $this->fkPatrimonioInventario = $fkPatrimonioInventario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioInventario
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Inventario
     */
    public function getFkPatrimonioInventario()
    {
        return $this->fkPatrimonioInventario;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioHistoricoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem
     * @return InventarioHistoricoBem
     */
    public function setFkPatrimonioHistoricoBem(\Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem $fkPatrimonioHistoricoBem)
    {
        $this->codBem = $fkPatrimonioHistoricoBem->getCodBem();
        $this->timestampHistorico = $fkPatrimonioHistoricoBem->getTimestamp();
        $this->fkPatrimonioHistoricoBem = $fkPatrimonioHistoricoBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioHistoricoBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem
     */
    public function getFkPatrimonioHistoricoBem()
    {
        return $this->fkPatrimonioHistoricoBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem
     * @return InventarioHistoricoBem
     */
    public function setFkPatrimonioBem(\Urbem\CoreBundle\Entity\Patrimonio\Bem $fkPatrimonioBem)
    {
        $this->codBem = $fkPatrimonioBem->getCodBem();
        $this->fkPatrimonioBem = $fkPatrimonioBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\Bem
     */
    public function getFkPatrimonioBem()
    {
        return $this->fkPatrimonioBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPatrimonioSituacaoBem
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem $fkPatrimonioSituacaoBem
     * @return InventarioHistoricoBem
     */
    public function setFkPatrimonioSituacaoBem(\Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem $fkPatrimonioSituacaoBem)
    {
        $this->codSituacao = $fkPatrimonioSituacaoBem->getCodSituacao();
        $this->fkPatrimonioSituacaoBem = $fkPatrimonioSituacaoBem;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPatrimonioSituacaoBem
     *
     * @return \Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem
     */
    public function getFkPatrimonioSituacaoBem()
    {
        return $this->fkPatrimonioSituacaoBem;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return InventarioHistoricoBem
     */
    public function setFkOrganogramaLocal(\Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal)
    {
        $this->codLocal = $fkOrganogramaLocal->getCodLocal();
        $this->fkOrganogramaLocal = $fkOrganogramaLocal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaLocal
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Local
     */
    public function getFkOrganogramaLocal()
    {
        return $this->fkOrganogramaLocal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return InventarioHistoricoBem
     */
    public function setFkOrganogramaOrgao(\Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao)
    {
        $this->codOrgao = $fkOrganogramaOrgao->getCodOrgao();
        $this->fkOrganogramaOrgao = $fkOrganogramaOrgao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrganogramaOrgao
     *
     * @return \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    public function getFkOrganogramaOrgao()
    {
        return $this->fkOrganogramaOrgao;
    }
}
