<?php
 
namespace Urbem\CoreBundle\Entity\Tcmba;

/**
 * FonteRecursoLocal
 */
class FonteRecursoLocal
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
    private $codLocal;

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
     * @var \Urbem\CoreBundle\Entity\Organograma\Local
     */
    private $fkOrganogramaLocal;


    /**
     * Set codTipoFonte
     *
     * @param integer $codTipoFonte
     * @return FonteRecursoLocal
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
     * @return FonteRecursoLocal
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
     * @return FonteRecursoLocal
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
     * Set codLocal
     *
     * @param integer $codLocal
     * @return FonteRecursoLocal
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
     * ManyToOne (inverse side)
     * Set fkTcmbaTipoFonteRecursoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Tcmba\TipoFonteRecursoServidor $fkTcmbaTipoFonteRecursoServidor
     * @return FonteRecursoLocal
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
     * @return FonteRecursoLocal
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
     * Set fkOrganogramaLocal
     *
     * @param \Urbem\CoreBundle\Entity\Organograma\Local $fkOrganogramaLocal
     * @return FonteRecursoLocal
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
}
