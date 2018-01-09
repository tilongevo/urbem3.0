<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * PrescricaoExame
 */
class PrescricaoExame
{
    /**
     * PK
     * @var integer
     */
    private $codExame;

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
     * PK
     * @var integer
     */
    private $codTipoExame;

    /**
     * @var \DateTime
     */
    private $dtRealizacao;

    /**
     * @var string
     */
    private $descricao;

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
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\TipoExame
     */
    private $fkCseTipoExame;


    /**
     * Set codExame
     *
     * @param integer $codExame
     * @return PrescricaoExame
     */
    public function setCodExame($codExame)
    {
        $this->codExame = $codExame;
        return $this;
    }

    /**
     * Get codExame
     *
     * @return integer
     */
    public function getCodExame()
    {
        return $this->codExame;
    }

    /**
     * Set codInstituicao
     *
     * @param integer $codInstituicao
     * @return PrescricaoExame
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
     * @return PrescricaoExame
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
     * @return PrescricaoExame
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
     * @return PrescricaoExame
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
     * @return PrescricaoExame
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
     * Set codTipoExame
     *
     * @param integer $codTipoExame
     * @return PrescricaoExame
     */
    public function setCodTipoExame($codTipoExame)
    {
        $this->codTipoExame = $codTipoExame;
        return $this;
    }

    /**
     * Get codTipoExame
     *
     * @return integer
     */
    public function getCodTipoExame()
    {
        return $this->codTipoExame;
    }

    /**
     * Set dtRealizacao
     *
     * @param \DateTime $dtRealizacao
     * @return PrescricaoExame
     */
    public function setDtRealizacao(\DateTime $dtRealizacao)
    {
        $this->dtRealizacao = $dtRealizacao;
        return $this;
    }

    /**
     * Get dtRealizacao
     *
     * @return \DateTime
     */
    public function getDtRealizacao()
    {
        return $this->dtRealizacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return PrescricaoExame
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
     * Set fkCseInstituicaoSaude
     *
     * @param \Urbem\CoreBundle\Entity\Cse\InstituicaoSaude $fkCseInstituicaoSaude
     * @return PrescricaoExame
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
     * @return PrescricaoExame
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

    /**
     * ManyToOne (inverse side)
     * Set fkCseTipoExame
     *
     * @param \Urbem\CoreBundle\Entity\Cse\TipoExame $fkCseTipoExame
     * @return PrescricaoExame
     */
    public function setFkCseTipoExame(\Urbem\CoreBundle\Entity\Cse\TipoExame $fkCseTipoExame)
    {
        $this->codTipoExame = $fkCseTipoExame->getCodExame();
        $this->fkCseTipoExame = $fkCseTipoExame;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseTipoExame
     *
     * @return \Urbem\CoreBundle\Entity\Cse\TipoExame
     */
    public function getFkCseTipoExame()
    {
        return $this->fkCseTipoExame;
    }
}
