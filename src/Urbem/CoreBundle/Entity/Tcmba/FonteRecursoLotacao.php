<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * FonteRecursoLotacao
 */
class FonteRecursoLotacao
{
    /**
     * PK
     * @var integer
     */
    private $codTipoFonte;

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
    private $codOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmba\TipoFonteRecursoServidor
     */
    private $fkTcmbaTipoFonteRecursoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    private $fkOrcamentoEntidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Orgao
     */
    private $fkOrganogramaOrgao;


    /**
     * Set codTipoFonte
     *
     * @param integer $codTipoFonte
     * @return FonteRecursoLotacao
     */
    public function setCodTipoFonte($codTipoFonte)
    {
        $this->codTipoFonte = $codTipoFonte;
        return $this;
    }

    /**
     * Get codTipoFonte
     *
     * @return integer
     */
    public function getCodTipoFonte()
    {
        return $this->codTipoFonte;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return FonteRecursoLotacao
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
     * @return FonteRecursoLotacao
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
     * Set codOrgao
     *
     * @param integer $codOrgao
     * @return FonteRecursoLotacao
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
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoFonteRecursoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoFonteRecursoServidor $fkTcmbaTipoFonteRecursoServidor
     * @return FonteRecursoLotacao
     */
    public function setFkTcmbaTipoFonteRecursoServidor(\Urbem\CoreBundle\Entity\Tcmba\TipoFonteRecursoServidor $fkTcmbaTipoFonteRecursoServidor)
    {
        $this->codTipoFonte = $fkTcmbaTipoFonteRecursoServidor->getCodTipoFonte();
        $this->fkTcmbaTipoFonteRecursoServidor = $fkTcmbaTipoFonteRecursoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmbaTipoFonteRecursoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Tcmba\TipoFonteRecursoServidor
     */
    public function getFkTcmbaTipoFonteRecursoServidor()
    {
        return $this->fkTcmbaTipoFonteRecursoServidor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoEntidade
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade
     * @return FonteRecursoLotacao
     */
    public function setFkOrcamentoEntidade(\Urbem\CoreBundle\Entity\Orcamento\Entidade $fkOrcamentoEntidade)
    {
        $this->exercicio = $fkOrcamentoEntidade->getExercicio();
        $this->codEntidade = $fkOrcamentoEntidade->getCodEntidade();
        $this->fkOrcamentoEntidade = $fkOrcamentoEntidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoEntidade
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Entidade
     */
    public function getFkOrcamentoEntidade()
    {
        return $this->fkOrcamentoEntidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrganogramaOrgao
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Orgao $fkOrganogramaOrgao
     * @return FonteRecursoLotacao
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
