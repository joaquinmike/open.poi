<?php

namespace Sys\Entity;

class SysCountry
{
    /**
     * @var string
     *
     * @ORM\Column(name="camp_id", type="string", length=8, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $campId;

    /**
     * @var integer
     *
     * @ORM\Column(name="partner_id", type="integer", nullable=false)
     */
    private $partnerId = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="camp_nombre", type="string", length=64, nullable=true)
     */
    private $campNombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="camp_fecha_inicio", type="datetime", nullable=true)
     */
    private $campFechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="camp_fecha_final", type="datetime", nullable=true)
     */
    private $campFechaFinal;

    /**
     * @var integer
     *
     * @ORM\Column(name="camp_estado", type="integer", nullable=true)
     */
    private $campEstado;

    /**
     * @var integer
     *
     * @ORM\Column(name="campania_tipo", type="integer", nullable=true)
     */
    private $campaniaTipo;



    /**
     * Get campId
     *
     * @return string 
     */
    public function getCampId()
    {
        return $this->campId;
    }

    /**
     * Set partnerId
     *
     * @param integer $partnerId
     * @return SysCampania
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    /**
     * Get partnerId
     *
     * @return integer 
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return SysCampania
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set campNombre
     *
     * @param string $campNombre
     * @return SysCampania
     */
    public function setCampNombre($campNombre)
    {
        $this->campNombre = $campNombre;

        return $this;
    }

    /**
     * Get campNombre
     *
     * @return string 
     */
    public function getCampNombre()
    {
        return $this->campNombre;
    }

    /**
     * Set campFechaInicio
     *
     * @param \DateTime $campFechaInicio
     * @return SysCampania
     */
    public function setCampFechaInicio($campFechaInicio)
    {
        $this->campFechaInicio = $campFechaInicio;

        return $this;
    }

    /**
     * Get campFechaInicio
     *
     * @return \DateTime 
     */
    public function getCampFechaInicio()
    {
        return $this->campFechaInicio;
    }

    /**
     * Set campFechaFinal
     *
     * @param \DateTime $campFechaFinal
     * @return SysCampania
     */
    public function setCampFechaFinal($campFechaFinal)
    {
        $this->campFechaFinal = $campFechaFinal;

        return $this;
    }

    /**
     * Get campFechaFinal
     *
     * @return \DateTime 
     */
    public function getCampFechaFinal()
    {
        return $this->campFechaFinal;
    }

    /**
     * Set campEstado
     *
     * @param integer $campEstado
     * @return SysCampania
     */
    public function setCampEstado($campEstado)
    {
        $this->campEstado = $campEstado;

        return $this;
    }

    /**
     * Get campEstado
     *
     * @return integer 
     */
    public function getCampEstado()
    {
        return $this->campEstado;
    }

    /**
     * Set campaniaTipo
     *
     * @param integer $campaniaTipo
     * @return SysCampania
     */
    public function setCampaniaTipo($campaniaTipo)
    {
        $this->campaniaTipo = $campaniaTipo;

        return $this;
    }

    /**
     * Get campaniaTipo
     *
     * @return integer 
     */
    public function getCampaniaTipo()
    {
        return $this->campaniaTipo;
    }
}
