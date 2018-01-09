<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * NotaLiquidacaoDocumento
 */
class NotaLiquidacaoDocumento
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
    private $codEntidade;

    /**
     * PK
     * @var integer
     */
    private $codNota;

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
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao
     */
    private $fkEmpenhoNotaLiquidacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceto\TipoDocumento
     */
    private $fkTcetoTipoDocumento;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return NotaLiquidacaoDocumento
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
     * Set codEntidade
     *
     * @param integer $codEntidade
     * @return NotaLiquidacaoDocumento
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
     * Set codNota
     *
     * @param integer $codNota
     * @return NotaLiquidacaoDocumento
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
     * Set codTipo
     *
     * @param integer $codTipo
     * @return NotaLiquidacaoDocumento
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
     * @return NotaLiquidacaoDocumento
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
     * @return NotaLiquidacaoDocumento
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
     * @return NotaLiquidacaoDocumento
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
     * @return NotaLiquidacaoDocumento
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
     * @return NotaLiquidacaoDocumento
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
     * ManyToOne (inverse side)
     * Set fkTcetoTipoDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\TipoDocumento $fkTcetoTipoDocumento
     * @return NotaLiquidacaoDocumento
     */
    public function setFkTcetoTipoDocumento(\Urbem\CoreBundle\Entity\Tceto\TipoDocumento $fkTcetoTipoDocumento)
    {
        $this->codTipo = $fkTcetoTipoDocumento->getCodTipo();
        $this->fkTcetoTipoDocumento = $fkTcetoTipoDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcetoTipoDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\TipoDocumento
     */
    public function getFkTcetoTipoDocumento()
    {
        return $this->fkTcetoTipoDocumento;
    }

    /**
     * OneToOne (owning side)
     * Set EmpenhoNotaLiquidacao
     *
     * @param \Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao $fkEmpenhoNotaLiquidacao
     * @return NotaLiquidacaoDocumento
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
