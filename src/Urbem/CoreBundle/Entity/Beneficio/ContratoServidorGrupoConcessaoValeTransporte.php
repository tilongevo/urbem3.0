<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * ContratoServidorGrupoConcessaoValeTransporte
 */
class ContratoServidorGrupoConcessaoValeTransporte
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessao
     */
    private $fkBeneficioGrupoConcessao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    private $fkPessoalContratoServidor;


    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return ContratoServidorGrupoConcessaoValeTransporte
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ContratoServidorGrupoConcessaoValeTransporte
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioGrupoConcessao
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessao $fkBeneficioGrupoConcessao
     * @return ContratoServidorGrupoConcessaoValeTransporte
     */
    public function setFkBeneficioGrupoConcessao(\Urbem\CoreBundle\Entity\Beneficio\GrupoConcessao $fkBeneficioGrupoConcessao)
    {
        $this->codGrupo = $fkBeneficioGrupoConcessao->getCodGrupo();
        $this->fkBeneficioGrupoConcessao = $fkBeneficioGrupoConcessao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioGrupoConcessao
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\GrupoConcessao
     */
    public function getFkBeneficioGrupoConcessao()
    {
        return $this->fkBeneficioGrupoConcessao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContratoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor
     * @return ContratoServidorGrupoConcessaoValeTransporte
     */
    public function setFkPessoalContratoServidor(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidor $fkPessoalContratoServidor)
    {
        $this->codContrato = $fkPessoalContratoServidor->getCodContrato();
        $this->fkPessoalContratoServidor = $fkPessoalContratoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContratoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\ContratoServidor
     */
    public function getFkPessoalContratoServidor()
    {
        return $this->fkPessoalContratoServidor;
    }
}
