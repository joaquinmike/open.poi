<?php

namespace Sys\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysLogTransacciones
 *
 * @ORM\Table(name="sys_log_transacciones")
 * @ORM\Entity
 */
class SysLogTransacciones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="transaction_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $transactionId;

    /**
     * @var string
     *
     * @ORM\Column(name="log_table", type="string", length=64, nullable=true)
     */
    private $logTable;

    /**
     * @var string
     *
     * @ORM\Column(name="log_query", type="text", nullable=true)
     */
    private $logQuery;

    /**
     * @var string
     *
     * @ORM\Column(name="log_detalle", type="text", nullable=true)
     */
    private $logDetalle;

    /**
     * @var string
     *
     * @ORM\Column(name="log_action", type="text", nullable=true)
     */
    private $logAction;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_registro", type="datetime", nullable=true)
     */
    private $fechaRegistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_edicion", type="datetime", nullable=true)
     */
    private $fechaEdicion;

    /**
     * @var integer
     *
     * @ORM\Column(name="log_estado_anterior", type="integer", nullable=true)
     */
    private $logEstadoAnterior;



    /**
     * Get transactionId
     *
     * @return integer 
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set logTable
     *
     * @param string $logTable
     * @return SysLogTransacciones
     */
    public function setLogTable($logTable)
    {
        $this->logTable = $logTable;

        return $this;
    }

    /**
     * Get logTable
     *
     * @return string 
     */
    public function getLogTable()
    {
        return $this->logTable;
    }

    /**
     * Set logQuery
     *
     * @param string $logQuery
     * @return SysLogTransacciones
     */
    public function setLogQuery($logQuery)
    {
        $this->logQuery = $logQuery;

        return $this;
    }

    /**
     * Get logQuery
     *
     * @return string 
     */
    public function getLogQuery()
    {
        return $this->logQuery;
    }

    /**
     * Set logDetalle
     *
     * @param string $logDetalle
     * @return SysLogTransacciones
     */
    public function setLogDetalle($logDetalle)
    {
        $this->logDetalle = $logDetalle;

        return $this;
    }

    /**
     * Get logDetalle
     *
     * @return string 
     */
    public function getLogDetalle()
    {
        return $this->logDetalle;
    }

    /**
     * Set logAction
     *
     * @param string $logAction
     * @return SysLogTransacciones
     */
    public function setLogAction($logAction)
    {
        $this->logAction = $logAction;

        return $this;
    }

    /**
     * Get logAction
     *
     * @return string 
     */
    public function getLogAction()
    {
        return $this->logAction;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return SysLogTransacciones
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime 
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Set fechaEdicion
     *
     * @param \DateTime $fechaEdicion
     * @return SysLogTransacciones
     */
    public function setFechaEdicion($fechaEdicion)
    {
        $this->fechaEdicion = $fechaEdicion;

        return $this;
    }

    /**
     * Get fechaEdicion
     *
     * @return \DateTime 
     */
    public function getFechaEdicion()
    {
        return $this->fechaEdicion;
    }

    /**
     * Set logEstadoAnterior
     *
     * @param integer $logEstadoAnterior
     * @return SysLogTransacciones
     */
    public function setLogEstadoAnterior($logEstadoAnterior)
    {
        $this->logEstadoAnterior = $logEstadoAnterior;

        return $this;
    }

    /**
     * Get logEstadoAnterior
     *
     * @return integer 
     */
    public function getLogEstadoAnterior()
    {
        return $this->logEstadoAnterior;
    }
}
