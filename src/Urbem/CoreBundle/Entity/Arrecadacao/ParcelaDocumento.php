<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ParcelaDocumento
 */
class ParcelaDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codParcela;

    /**
     * PK
     * @var integer
     */
    private $codDocumento;

    /**
     * PK
     * @var integer
     */
    private $numDocumento;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codSituacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    private $fkArrecadacaoParcela;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    private $fkArrecadacaoDocumentoEmissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\SituacaoParcela
     */
    private $fkArrecadacaoSituacaoParcela;


    /**
     * Set codParcela
     *
     * @param integer $codParcela
     * @return ParcelaDocumento
     */
    public function setCodParcela($codParcela)
    {
        $this->codParcela = $codParcela;
        return $this;
    }

    /**
     * Get codParcela
     *
     * @return integer
     */
    public function getCodParcela()
    {
        return $this->codParcela;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return ParcelaDocumento
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
     * Set numDocumento
     *
     * @param integer $numDocumento
     * @return ParcelaDocumento
     */
    public function setNumDocumento($numDocumento)
    {
        $this->numDocumento = $numDocumento;
        return $this;
    }

    /**
     * Get numDocumento
     *
     * @return integer
     */
    public function getNumDocumento()
    {
        return $this->numDocumento;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ParcelaDocumento
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
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return ParcelaDocumento
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela
     * @return ParcelaDocumento
     */
    public function setFkArrecadacaoParcela(\Urbem\CoreBundle\Entity\Arrecadacao\Parcela $fkArrecadacaoParcela)
    {
        $this->codParcela = $fkArrecadacaoParcela->getCodParcela();
        $this->fkArrecadacaoParcela = $fkArrecadacaoParcela;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Parcela
     */
    public function getFkArrecadacaoParcela()
    {
        return $this->fkArrecadacaoParcela;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoDocumentoEmissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao
     * @return ParcelaDocumento
     */
    public function setFkArrecadacaoDocumentoEmissao(\Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao $fkArrecadacaoDocumentoEmissao)
    {
        $this->codDocumento = $fkArrecadacaoDocumentoEmissao->getCodDocumento();
        $this->numDocumento = $fkArrecadacaoDocumentoEmissao->getNumDocumento();
        $this->exercicio = $fkArrecadacaoDocumentoEmissao->getExercicio();
        $this->fkArrecadacaoDocumentoEmissao = $fkArrecadacaoDocumentoEmissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoDocumentoEmissao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao
     */
    public function getFkArrecadacaoDocumentoEmissao()
    {
        return $this->fkArrecadacaoDocumentoEmissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoSituacaoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\SituacaoParcela $fkArrecadacaoSituacaoParcela
     * @return ParcelaDocumento
     */
    public function setFkArrecadacaoSituacaoParcela(\Urbem\CoreBundle\Entity\Arrecadacao\SituacaoParcela $fkArrecadacaoSituacaoParcela)
    {
        $this->codSituacao = $fkArrecadacaoSituacaoParcela->getCodSituacao();
        $this->fkArrecadacaoSituacaoParcela = $fkArrecadacaoSituacaoParcela;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoSituacaoParcela
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\SituacaoParcela
     */
    public function getFkArrecadacaoSituacaoParcela()
    {
        return $this->fkArrecadacaoSituacaoParcela;
    }
}
