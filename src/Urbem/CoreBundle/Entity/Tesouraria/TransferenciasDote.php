<?php
 
namespace Urbem\CoreBundle\Entity\Tesouraria;

/**
 * TransferenciasDote
 */
class TransferenciasDote
{
    /**
     * PK
     * @var integer
     */
    private $codDote;

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
    private $codPlanoDebito;

    /**
     * PK
     * @var integer
     */
    private $codPlanoCredito;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var integer
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tesouraria\Dote
     */
    private $fkTesourariaDote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    private $fkContabilidadePlanoAnalitica1;


    /**
     * Set codDote
     *
     * @param integer $codDote
     * @return TransferenciasDote
     */
    public function setCodDote($codDote)
    {
        $this->codDote = $codDote;
        return $this;
    }

    /**
     * Get codDote
     *
     * @return integer
     */
    public function getCodDote()
    {
        return $this->codDote;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TransferenciasDote
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
     * @return TransferenciasDote
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
     * Set codPlanoDebito
     *
     * @param integer $codPlanoDebito
     * @return TransferenciasDote
     */
    public function setCodPlanoDebito($codPlanoDebito)
    {
        $this->codPlanoDebito = $codPlanoDebito;
        return $this;
    }

    /**
     * Get codPlanoDebito
     *
     * @return integer
     */
    public function getCodPlanoDebito()
    {
        return $this->codPlanoDebito;
    }

    /**
     * Set codPlanoCredito
     *
     * @param integer $codPlanoCredito
     * @return TransferenciasDote
     */
    public function setCodPlanoCredito($codPlanoCredito)
    {
        $this->codPlanoCredito = $codPlanoCredito;
        return $this;
    }

    /**
     * Get codPlanoCredito
     *
     * @return integer
     */
    public function getCodPlanoCredito()
    {
        return $this->codPlanoCredito;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TransferenciasDote
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
     * Set valor
     *
     * @param integer $valor
     * @return TransferenciasDote
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return integer
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTesourariaDote
     *
     * @param \Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote
     * @return TransferenciasDote
     */
    public function setFkTesourariaDote(\Urbem\CoreBundle\Entity\Tesouraria\Dote $fkTesourariaDote)
    {
        $this->codDote = $fkTesourariaDote->getCodDote();
        $this->exercicio = $fkTesourariaDote->getExercicio();
        $this->codEntidade = $fkTesourariaDote->getCodEntidade();
        $this->fkTesourariaDote = $fkTesourariaDote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTesourariaDote
     *
     * @return \Urbem\CoreBundle\Entity\Tesouraria\Dote
     */
    public function getFkTesourariaDote()
    {
        return $this->fkTesourariaDote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica
     * @return TransferenciasDote
     */
    public function setFkContabilidadePlanoAnalitica(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica)
    {
        $this->codPlanoDebito = $fkContabilidadePlanoAnalitica->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica->getExercicio();
        $this->fkContabilidadePlanoAnalitica = $fkContabilidadePlanoAnalitica;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica()
    {
        return $this->fkContabilidadePlanoAnalitica;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkContabilidadePlanoAnalitica1
     *
     * @param \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica1
     * @return TransferenciasDote
     */
    public function setFkContabilidadePlanoAnalitica1(\Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica $fkContabilidadePlanoAnalitica1)
    {
        $this->codPlanoCredito = $fkContabilidadePlanoAnalitica1->getCodPlano();
        $this->exercicio = $fkContabilidadePlanoAnalitica1->getExercicio();
        $this->fkContabilidadePlanoAnalitica1 = $fkContabilidadePlanoAnalitica1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkContabilidadePlanoAnalitica1
     *
     * @return \Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica
     */
    public function getFkContabilidadePlanoAnalitica1()
    {
        return $this->fkContabilidadePlanoAnalitica1;
    }
}
