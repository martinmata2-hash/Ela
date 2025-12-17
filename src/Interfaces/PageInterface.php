<?php
/**
 * Interface para clase Pagina 
 */
namespace Marve\Ela\Interfaces;

interface PageInterface
{
    
    function render();
    
    function header();
    
    function headerMenu();
    
    function sideMenu();
    
    function footer();
    
    function body();
}

