<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * QualificacaoProfissional
 */
class QualificacaoProfissional
{
    /**
     * PK
     * @var integer
     */
    private $codProfissao;

    /**
     * PK
     * @var integer
     */
    private $codEmpresa;

    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * @var \DateTime
     */
    private $dtCadastro;

    /**
     * @var \DateTime
     */
    private $dtAdmissao;

    /**
     * @var boolean
     */
    private $empregoAtual = true;

    /**
     * @var string
     */
    private $ocupacao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    private $fkCseProfissao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Empresa
     */
    private $fkCseEmpresa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    private $fkCseCidadao;


    /**
     * Set codProfissao
     *
     * @param integer $codProfissao
     * @return QualificacaoProfissional
     */
    public function setCodProfissao($codProfissao)
    {
        $this->codProfissao = $codProfissao;
        return $this;
    }

    /**
     * Get codProfissao
     *
     * @return integer
     */
    public function getCodProfissao()
    {
        return $this->codProfissao;
    }

    /**
     * Set codEmpresa
     *
     * @param integer $codEmpresa
     * @return QualificacaoProfissional
     */
    public function setCodEmpresa($codEmpresa)
    {
        $this->codEmpresa = $codEmpresa;
        return $this;
    }

    /**
     * Get codEmpresa
     *
     * @return integer
     */
    public function getCodEmpresa()
    {
        return $this->codEmpresa;
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return QualificacaoProfissional
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
     * Set dtCadastro
     *
     * @param \DateTime $dtCadastro
     * @return QualificacaoProfissional
     */
    public function setDtCadastro(\DateTime $dtCadastro)
    {
        $this->dtCadastro = $dtCadastro;
        return $this;
    }

    /**
     * Get dtCadastro
     *
     * @return \DateTime
     */
    public function getDtCadastro()
    {
        return $this->dtCadastro;
    }

    /**
     * Set dtAdmissao
     *
     * @param \DateTime $dtAdmissao
     * @return QualificacaoProfissional
     */
    public function setDtAdmissao(\DateTime $dtAdmissao = null)
    {
        $this->dtAdmissao = $dtAdmissao;
        return $this;
    }

    /**
     * Get dtAdmissao
     *
     * @return \DateTime
     */
    public function getDtAdmissao()
    {
        return $this->dtAdmissao;
    }

    /**
     * Set empregoAtual
     *
     * @param boolean $empregoAtual
     * @return QualificacaoProfissional
     */
    public function setEmpregoAtual($empregoAtual)
    {
        $this->empregoAtual = $empregoAtual;
        return $this;
    }

    /**
     * Get empregoAtual
     *
     * @return boolean
     */
    public function getEmpregoAtual()
    {
        return $this->empregoAtual;
    }

    /**
     * Set ocupacao
     *
     * @param string $ocupacao
     * @return QualificacaoProfissional
     */
    public function setOcupacao($ocupacao)
    {
        $this->ocupacao = $ocupacao;
        return $this;
    }

    /**
     * Get ocupacao
     *
     * @return string
     */
    public function getOcupacao()
    {
        return $this->ocupacao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseProfissao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao
     * @return QualificacaoProfissional
     */
    public function setFkCseProfissao(\Urbem\CoreBundle\Entity\Cse\Profissao $fkCseProfissao)
    {
        $this->codProfissao = $fkCseProfissao->getCodProfissao();
        $this->fkCseProfissao = $fkCseProfissao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseProfissao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Profissao
     */
    public function getFkCseProfissao()
    {
        return $this->fkCseProfissao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseEmpresa
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Empresa $fkCseEmpresa
     * @return QualificacaoProfissional
     */
    public function setFkCseEmpresa(\Urbem\CoreBundle\Entity\Cse\Empresa $fkCseEmpresa)
    {
        $this->codEmpresa = $fkCseEmpresa->getCodEmpresa();
        $this->fkCseEmpresa = $fkCseEmpresa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseEmpresa
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Empresa
     */
    public function getFkCseEmpresa()
    {
        return $this->fkCseEmpresa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkCseCidadao
     *
     * @param \Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao
     * @return QualificacaoProfissional
     */
    public function setFkCseCidadao(\Urbem\CoreBundle\Entity\Cse\Cidadao $fkCseCidadao)
    {
        $this->codCidadao = $fkCseCidadao->getCodCidadao();
        $this->fkCseCidadao = $fkCseCidadao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkCseCidadao
     *
     * @return \Urbem\CoreBundle\Entity\Cse\Cidadao
     */
    public function getFkCseCidadao()
    {
        return $this->fkCseCidadao;
    }
}
