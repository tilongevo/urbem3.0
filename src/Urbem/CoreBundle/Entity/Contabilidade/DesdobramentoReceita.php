<?php
 
namespace Urbem\CoreBundle\Entity\Contabilidade;

/**
 * DesdobramentoReceita
 */
class DesdobramentoReceita
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
    private $codReceitaPrincipal;

    /**
     * PK
     * @var integer
     */
    private $codReceitaSecundaria;

    /**
     * @var integer
     */
    private $percentual;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    private $fkOrcamentoReceita1;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DesdobramentoReceita
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
     * Set codReceitaPrincipal
     *
     * @param integer $codReceitaPrincipal
     * @return DesdobramentoReceita
     */
    public function setCodReceitaPrincipal($codReceitaPrincipal)
    {
        $this->codReceitaPrincipal = $codReceitaPrincipal;
        return $this;
    }

    /**
     * Get codReceitaPrincipal
     *
     * @return integer
     */
    public function getCodReceitaPrincipal()
    {
        return $this->codReceitaPrincipal;
    }

    /**
     * Set codReceitaSecundaria
     *
     * @param integer $codReceitaSecundaria
     * @return DesdobramentoReceita
     */
    public function setCodReceitaSecundaria($codReceitaSecundaria)
    {
        $this->codReceitaSecundaria = $codReceitaSecundaria;
        return $this;
    }

    /**
     * Get codReceitaSecundaria
     *
     * @return integer
     */
    public function getCodReceitaSecundaria()
    {
        return $this->codReceitaSecundaria;
    }

    /**
     * Set percentual
     *
     * @param integer $percentual
     * @return DesdobramentoReceita
     */
    public function setPercentual($percentual = null)
    {
        $this->percentual = $percentual;
        return $this;
    }

    /**
     * Get percentual
     *
     * @return integer
     */
    public function getPercentual()
    {
        return $this->percentual;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita
     * @return DesdobramentoReceita
     */
    public function setFkOrcamentoReceita(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita)
    {
        $this->exercicio = $fkOrcamentoReceita->getExercicio();
        $this->codReceitaPrincipal = $fkOrcamentoReceita->getCodReceita();
        $this->fkOrcamentoReceita = $fkOrcamentoReceita;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita()
    {
        return $this->fkOrcamentoReceita;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoReceita1
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita1
     * @return DesdobramentoReceita
     */
    public function setFkOrcamentoReceita1(\Urbem\CoreBundle\Entity\Orcamento\Receita $fkOrcamentoReceita1)
    {
        $this->exercicio = $fkOrcamentoReceita1->getExercicio();
        $this->codReceitaSecundaria = $fkOrcamentoReceita1->getCodReceita();
        $this->fkOrcamentoReceita1 = $fkOrcamentoReceita1;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoReceita1
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\Receita
     */
    public function getFkOrcamentoReceita1()
    {
        return $this->fkOrcamentoReceita1;
    }
}
