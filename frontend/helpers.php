<?php
function escapar($valor)
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}
