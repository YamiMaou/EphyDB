<?php

namespace EphyDB;

interface Preparable
{
    /**
     * @return \PDOStatement
     */
    public function prepare();
}