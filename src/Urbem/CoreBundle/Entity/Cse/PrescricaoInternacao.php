<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * PrescricaoInternacao
 */
class PrescricaoInternacao
{
    /**
     * PK
     * @var integer
     */
    private $codInternacao;

    /**
     * PK
     * @var integer
     */
    private $codInstituicao;

    /**
     * PK
     * @var integer
     */
    private $codPrescricao;

    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * @var \DateTime
     */
    private $dtBaixa;

    /**
     * @var \DateTime
     */
    private $dtAlta;

    /**
     * @var string
     */
    private $motivo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\InstituicaoSaude
     */
    private $fkCseInstituicaoSaude;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Prescricao
     */
    private $fkCsePrescricao;


    /**
     * Set codInternacao
     *
     * @param integer $codInternacao
     * @return PrescricaoInternacao
     */
    public function setCodInternacao($codInternacao)
    {
        $this->codInternacao = $codInternacao;
        return $this;
    }

    /**
     * Get codInternacao
     *
     * @return integer
     */
    public function getCodInternacao()
    {
        return $this->codInternacao;
    }

    /**
     * Set codInstituicao
     *
     * @param integer $codInstituicao
     * @return PrescricaoInternacao
     */
    public function setCodInstituicao($codInstituicao)
    {
        $this->codInstituicao = $codInstituicao;
        return $this;
    }

    /**
     * Get codInstituicao
     *
     * @return integer
     */
    public function getCodInstituicao()
    {
        return $this->codInstituicao;
    }

    /**
     * Set codPrescricao
     *
     * @param integer $codPrescricao
     * @return PrescricaoInternacao
     */
    public function setCodPrescricao($codPrescricao)
    {
        $this->codPrescricao = $codPrescricao;
        return $this;
    }

    /**
     * Get codPrescricao
     *
     * @return integer
     */
    public function getCodPrescricao()
    {
        return $this->codPrescricao;
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return PrescricaoInternacao
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return PrescricaoInternacao
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
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return PrescricaoInternacao
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set dtBaixa
     *
     * @param \DateTime $dtBaixa
     * @return PrescricaoInternacao
     */
    public function setDtBaixa(\DateTime $dtBaixa)
    {
        $this->dtBaixa = $dtBaixa;
        return $this;
    }

    /**
     * Get dtBaixa
     *
     * @return \DateTime
     */
    public function getDtBaixa()
    {
        return $this->dtBaixa;
    }

    /**
     * Set dtAlta
     *
     * @param \DateTime $dtAlta
     * @return PrescricaoInternacao
     */
    public function setDtAlta(\DateTime $dtAlta = null)
    {
        $this->dtAlta = $dtAlta;
        return $this;
    }

    /**
     * Get dtAlta
     *
     * @return \DateTime
     */
    public function getDtAlta()
    {
        return $this->dtAlta;
    }

    /**
     * Set motivo
     *
     * @param string $motivo
     * @return PrescricaoInternacao
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;
        return $this;
    }

    /**
     * Get motivo
     *
     * @return string
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseInstituicaoSaude
     *
     * @param \Urbem\CoreBundle\Entity\Cse\InstituicaoSaude $fkCseInstituicaoSaude
     * @return PrescricaoInternacao
     */
    public function setFkCseInstituicaoSaude(\Urbem\CoreBundle\Entity\Cse\InstituicaoSaude $fkCseInstituicaoSaude)
    {
        $this->codInstituicao = $fkCseInstituicaoSaude->getCodInstituicao();
        $this->fkCseInstituicaoSaude = $fkCseInstituicaoSaude;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseInstituicaoSaude
     *
     * @return \Urbem\CoreBundle\Entity\Cse\InstituicaoSaude
     */
    public function getFkCseInstituicaoSaude()
    {
        return $this->fkCseInstituicaoSaude;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCsePrescricao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao
     * @return PrescricaoInternacao
     */
    public function setFkCsePrescricao(\Urbem\CoreBundle\Entity\Cse\Prescricao $fkCsePrescricao)
    {
        $this->codPrescricao = $fkCsePrescricao->getCodPrescricao();
        $this->codCidadao = $fkCsePrescricao->getCodCidadao();
        $this->codTipo = $fkCsePrescricao->getCodTipo();
        $this->codClassificacao = $fkCsePrescricao->getCodClassificacao();
        $this->fkCsePrescricao = $fkCsePrescricao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCsePrescricao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Prescricao
     */
    public function getFkCsePrescricao()
    {
        return $this->fkCsePrescricao;
    }
}
