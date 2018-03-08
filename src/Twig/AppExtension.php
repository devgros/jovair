<?php 
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            //new TwigFilter('last_date', array($this, 'lastDateFilter')),
        );
    }

    /*public function lastDateFilter($array)
    {
       
    }*/
}