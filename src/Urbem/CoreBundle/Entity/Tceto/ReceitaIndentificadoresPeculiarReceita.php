<?php
 
namespace Urbem\CoreBundle\Entity\Tceto;

/**
 * ReceitaIndentificadoresPeculiarReceita
 */
class ReceitaIndentificadoresPeculiarReceita
{
    /**
     * PK
     * @var integer
     */
    private $codReceita;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codIdentificador;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tceto\ValoresIdentificadores
     */
    private $fkTcetoValoresIdentificadores;


    /**
     * Set codReceita
     *
     * @param integer $codReceita
     * @return ReceitaIndentificadoresPeculiarReceita
     */
    public function setCodReceita($codReceita)
    {
        $this->codReceita = $codReceita;
        return $this;
    }

    /**
     * Get codReceita
     *
     * @return integer
     */
    public function getCodReceita()
    {
        return $this->codReceita;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ReceitaIndentificadoresPeculiarReceita
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
     * Set codIdentificador
     *
     * @param integer $codIdentificador
     * @return ReceitaIndentificadoresPeculiarReceita
     */
    public function setCodIdentificador($codIdentificador)
    {
        $this->codIdentificador = $codIdentificador;
        return $this;
    }

    /**
     * Get codIdentificador
     *
     * @return integer
     */
    public function getCodIdentificador()
    {
        return $this->codIdentificador;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcetoValoresIdentificadores
     *
     * @param \Urbem\CoreBundle\Entity\Tceto\ValoresIdentificadores $fkTcetoValoresIdentificadores
     * @return ReceitaIndentificadoresPeculiarReceita
     */
    public function setFkTcetoValoresIdentificadores(\Urbem\CoreBundle\Entity\Tceto\ValoresIdentificadores $fkTcetoValoresIdentificadores)
    {
        $this->codIdentificador = $fkTcetoValoresIdentificadores->getCodIdentificador();
        $this->fkTcetoValoresIdentificadores = $fkTcetoValoresIdentificadores;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcetoValoresIdentificadores
     *
     * @return \Urbem\CoreBundle\Entity\Tceto\ValoresIdentificadores
     */
    public function getFkTcetoValoresIdentificadores()
    {
        return $this->fkTcetoValoresIdentificadores;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return ReceitaIndentificadoresPeculiarReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceita = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }
}
