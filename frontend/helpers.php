<?php
/**
 * Funciones de ayuda (helpers)
 */
function escapar($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
