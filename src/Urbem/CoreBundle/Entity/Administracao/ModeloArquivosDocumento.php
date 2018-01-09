<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * ModeloArquivosDocumento
 */
class ModeloArquivosDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $codArquivo;

    /**
     * PK
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var boolean
     */
    private $sistema;

    /**
     * @var boolean
     */
    private $padrao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    private $fkAdministracaoAcao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento
     */
    private $fkAdministracaoArquivosDocumento;


    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return ModeloArquivosDocumento
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return ModeloArquivosDocumento
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
     * Set codArquivo
     *
     * @param integer $codArquivo
     * @return ModeloArquivosDocumento
     */
    public function setCodArquivo($codArquivo)
    {
        $this->codArquivo = $codArquivo;
        return $this;
    }

    /**
     * Get codArquivo
     *
     * @return integer
     */
    public function getCodArquivo()
    {
        return $this->codArquivo;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return ModeloArquivosDocumento
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
     * Set sistema
     *
     * @param boolean $sistema
     * @return ModeloArquivosDocumento
     */
    public function setSistema($sistema)
    {
        $this->sistema = $sistema;
        return $this;
    }

    /**
     * Get sistema
     *
     * @return boolean
     */
    public function getSistema()
    {
        return $this->sistema;
    }

    /**
     * Set padrao
     *
     * @param boolean $padrao
     * @return ModeloArquivosDocumento
     */
    public function setPadrao($padrao)
    {
        $this->padrao = $padrao;
        return $this;
    }

    /**
     * Get padrao
     *
     * @return boolean
     */
    public function getPadrao()
    {
        return $this->padrao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao
     * @return ModeloArquivosDocumento
     */
    public function setFkAdministracaoAcao(\Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao)
    {
        $this->codAcao = $fkAdministracaoAcao->getCodAcao();
        $this->fkAdministracaoAcao = $fkAdministracaoAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAcao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    public function getFkAdministracaoAcao()
    {
        return $this->fkAdministracaoAcao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return ModeloArquivosDocumento
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoArquivosDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento $fkAdministracaoArquivosDocumento
     * @return ModeloArquivosDocumento
     */
    public function setFkAdministracaoArquivosDocumento(\Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento $fkAdministracaoArquivosDocumento)
    {
        $this->codArquivo = $fkAdministracaoArquivosDocumento->getCodArquivo();
        $this->sistema = $fkAdministracaoArquivosDocumento->getSistema();
        $this->fkAdministracaoArquivosDocumento = $fkAdministracaoArquivosDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoArquivosDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento
     */
    public function getFkAdministracaoArquivosDocumento()
    {
        return $this->fkAdministracaoArquivosDocumento;
    }
}
