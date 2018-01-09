<?php
 
namespace Urbem\CoreBundle\Entity\Tceal;

/**
 * Documento
 */
class Documento
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
    private $codNota;

    /**
     * PK
     * @var integer
     */
    private $codEntidade;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nroDocumento;

    /**
     * @var \DateTime
     */
    private $dtDocumento;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $autorizacao;

    /**
     * @var string
     */
    private $modelo;

    /**
     * @var string
     */
    private $nroXmlNfe;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceal\TipoDocumento
     */
    private $fkTcealTipoDocumento;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return Documento
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
     * Set codNota
     *
     * @param integer $codNota
     * @return Documento
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return Documento
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Documento
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
     * Set nroDocumento
     *
     * @param string $nroDocumento
     * @return Documento
     */
    public function setNroDocumento($nroDocumento)
    {
        $this->nroDocumento = $nroDocumento;
        return $this;
    }

    /**
     * Get nroDocumento
     *
     * @return string
     */
    public function getNroDocumento()
    {
        return $this->nroDocumento;
    }

    /**
     * Set dtDocumento
     *
     * @param \DateTime $dtDocumento
     * @return Documento
     */
    public function setDtDocumento(\DateTime $dtDocumento = null)
    {
        $this->dtDocumento = $dtDocumento;
        return $this;
    }

    /**
     * Get dtDocumento
     *
     * @return \DateTime
     */
    public function getDtDocumento()
    {
        return $this->dtDocumento;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Documento
     */
    public function setDescricao($descricao = null)
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
     * Set autorizacao
     *
     * @param string $autorizacao
     * @return Documento
     */
    public function setAutorizacao($autorizacao = null)
    {
        $this->autorizacao = $autorizacao;
        return $this;
    }

    /**
     * Get autorizacao
     *
     * @return string
     */
    public function getAutorizacao()
    {
        return $this->autorizacao;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     * @return Documento
     */
    public function setModelo($modelo = null)
    {
        $this->modelo = $modelo;
        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set nroXmlNfe
     *
     * @param string $nroXmlNfe
     * @return Documento
     */
    public function setNroXmlNfe($nroXmlNfe = null)
    {
        $this->nroXmlNfe = $nroXmlNfe;
        return $this;
    }

    /**
     * Get nroXmlNfe
     *
     * @return string
     */
    public function getNroXmlNfe()
    {
        return $this->nroXmlNfe;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcealTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceal\TipoDocumento $fkTcealTipoDocumento
     * @return Documento
     */
    public function setFkTcealTipoDocumento(\Urbem\CoreBundle\Entity\Tceal\TipoDocumento $fkTcealTipoDocumento)
    {
        $this->codTipo = $fkTcealTipoDocumento->getCodTipo();
        $this->fkTcealTipoDocumento = $fkTcealTipoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcealTipoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tceal\TipoDocumento
     */
    public function getFkTcealTipoDocumento()
    {
        return $this->fkTcealTipoDocumento;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return Documento
     */
    public function setFkEmpenhoNotaLiquidacao(\Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao)
    {
        $this->exercicio = $fkEmpenhoNotaLiquidacao->getExercicio();
        $this->codNota = $fkEmpenhoNotaLiquidacao->getCodNota();
        $this->codEntidade = $fkEmpenhoNotaLiquidacao->getCodEntidade();
        $this->fkEmpenhoNotaLiquidacao = $fkEmpenhoNotaLiquidacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkEmpenhoNotaLiquidacao
     *
     * @return \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    public function getFkEmpenhoNotaLiquidacao()
    {
        return $this->fkEmpenhoNotaLiquidacao;
    }
}
