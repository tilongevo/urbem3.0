<?php

namespace Urbem\CoreBundle\Entity\Organograma;

/**
 * DeParaOrgaoDTO
 */
class DeParaOrgaoDTO
{
    /**
     * PK
     * @var integer
     */
    private $codDeParaOrgao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Organograma\Organograma
     */
    private $codOrganograma;

    /**
     * @return int
     */
    public function getCodDeParaOrgao()
    {
        return $this->codDeParaOrgao;
    }

    /**
     * @param int $codDeParaOrgao
     */
    public function setCodDeParaOrgao($codDeParaOrgao)
    {
        $this->codDeParaOrgao = $codDeParaOrgao;
    }

    /**
     * @return Organograma
     */
    public function getCodOrganograma()
    {
        return $this->codOrganograma;
    }

    /**
     * @param Organograma $codOrganograma
     */
    public function setCodOrganograma($codOrganograma)
    {
        $this->codOrganograma = $codOrganograma;
    }
}
